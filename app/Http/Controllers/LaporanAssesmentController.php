<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\AnggotaKelas;
use App\Models\Assesment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanAssesmentController extends Controller
{
public function index(Request $request)
{
    $user = Auth::guard('guru')->user() ?? Auth::guard('siswa')->user();

    if (!$user) {
        abort(403, 'Unauthorized');
    }

    // Jika user adalah guru
    if (Auth::guard('guru')->check()) {
        $role = $user->jabatan;

        switch ($role) {
case 'admin':
case 'kepala_sekolah':
    $query = WaliKelas::with(['kelas', 'tahunAjaran'])
        ->whereHas('anggotaKelas'); // hanya yang punya anggota kelas

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->whereHas('kelas', function ($kelasQuery) use ($search) {
                $kelasQuery->where('nama_kelas', 'like', "%{$search}%");
            })->orWhereHas('tahunAjaran', function ($taQuery) use ($search) {
                $taQuery->where('tahun_mulai', 'like', "%{$search}%")
                        ->orWhere('semester', 'like', "%{$search}%");
            });
        });
    }

    $waliKelasList = $query->get()
        ->sortBy([
            ['tahunAjaran.tahun_mulai', 'asc'],
            ['tahunAjaran.semester', 'asc'],
        ])
        ->values();

    $view = $role === 'admin' ? 'laporan-assesment.index' : 'laporan-assesment.kepsek';
    return view($view, compact('waliKelasList'));



            case 'wali_kelas':
                // Ambil semua data wali kelas berdasarkan NIP guru login
                $waliKelasList = WaliKelas::with(['kelas', 'tahunAjaran'])
                    ->where('NIP', $user->NIP)
                    ->get()
                    ->sortBy([
                        ['tahunAjaran.tahun_mulai', 'asc'],
                        ['tahunAjaran.semester', 'asc'],
                    ])
                    ->values();
                if ($waliKelasList->isEmpty()) {
                    return back()->with('error', 'Anda belum terdaftar sebagai wali kelas.');
                }

                return view('laporan-assesment.wakel', compact('waliKelasList'));

            default:
                abort(403, 'Role tidak dikenali');
        }
    }

    // Jika user adalah siswa
    elseif (Auth::guard('siswa')->check()) {
        $nis = $user->NIS;

        $anggota = AnggotaKelas::with(['siswa', 'waliKelas.kelas', 'waliKelas.tahunAjaran'])
            ->where('NIS', $nis)
            ->latest('id_wakel')
            ->first();

        if (!$anggota) {
            return back()->with('error', 'Data anggota kelas tidak ditemukan.');
        }

        $siswa = $anggota->siswa;
        $kelas = $anggota->waliKelas->kelas;
        $tahunAjaran = $anggota->waliKelas->tahunAjaran;

        $assesments = Assesment::with('tujuan_pembelajaran')
            ->where('NIS', $nis)
            ->orderBy('minggu')
            ->get();

        return view('laporan-assesment.ortu', compact('siswa', 'kelas', 'tahunAjaran', 'assesments'));
    }

    abort(403, 'Unauthorized');
}




   public function showByKelas(Request $request, $id_kelas, $id_ta)
{
    $role = session('role');
    $nip = Auth::guard('guru')->user()->NIP ?? null;

    $wakel = WaliKelas::where('id_kelas', $id_kelas)
                      ->where('id_ta', $id_ta)
                      ->firstOrFail();

    if ($role === 'wali_kelas' && $wakel->NIP !== $nip) {
        abort(403);
    }

    $search = $request->search;

    // Gunakan query builder agar bisa pagination
    $query = AnggotaKelas::with('siswa')
        ->where('id_wakel', $wakel->id_wakel)
        ->when($search, function ($q) use ($search) {
            $q->whereHas('siswa', function ($query) use ($search) {
                $query->where('nama_siswa', 'like', '%' . $search . '%');
            });
        });

    // Ambil data siswa paginasi
    $siswa = $query->paginate(10)->withQueryString();

    // Ambil seluruh assessment berdasarkan NIS yang ada di halaman saat ini
    $nisList = $siswa->pluck('NIS')->all();

    $assesments = Assesment::with('tujuan_pembelajaran')
        ->whereIn('NIS', $nisList)
        ->get()
        ->groupBy('NIS');

    return view('laporan-assesment.siswa', compact('siswa', 'assesments', 'wakel'));
}

    public function showDetail($nis, $id_tp, $id_ta)
{
    $role = session('role');

    if (!in_array($role, ['admin', 'kepala_sekolah', 'wali_kelas', 'orangtua'])) {
        abort(403);
    }

    if ($role === 'orangtua') {
        $nisLogin = Auth::guard('siswa')->user()->NIS;
        if ($nisLogin !== $nis) {
            abort(403);
        }
    }

    // Ambil data tahun ajaran
$tahunAjaran = TahunAjaran::findOrFail($id_ta);

// Ambil tahun awal dari format tahun ajaran, misalnya: 2024 dari "2024/2025"
$tahunAwal = substr($tahunAjaran->tahun_mulai, 0, 4);

$assesments = Assesment::with('tujuan_pembelajaran')
    ->where('NIS', $nis)
    ->where('id_tp', $id_tp)
    ->where('tahun', $tahunAwal)
    ->where('semester', $tahunAjaran->semester)
    ->orderBy('minggu')
    ->get();



    $siswa = Siswa::findOrFail($nis);

    switch ($role) {
        case 'orangtua':
            return view('laporan-assesment.ortu-detail', compact('assesments', 'siswa', 'tahunAjaran'));
        case 'wali_kelas':
            return view('laporan-assesment.wakel-detail', compact('assesments', 'siswa', 'tahunAjaran'));
        case 'kepala_sekolah':
            return view('laporan-assesment.kepsek-detail', compact('assesments', 'siswa', 'tahunAjaran'));
        case 'admin':
            return view('laporan-assesment.detail', compact('assesments', 'siswa', 'tahunAjaran'));
        default:
            abort(403);
    }
}


public function laporanOrangtua()
{
    $nis = Auth::guard('siswa')->user()->NIS;

    $anggota = AnggotaKelas::with(['siswa', 'waliKelas.kelas', 'waliKelas.tahunAjaran'])
        ->where('NIS', $nis)
        ->latest('id_wakel')
        ->firstOrFail();

    $siswa = $anggota->siswa;
    $kelas = $anggota->waliKelas->kelas;
    $tahunAjaran = $anggota->waliKelas->tahunAjaran; // <-- pastikan ini ada

    $assesments = Assesment::with('tujuan_pembelajaran')
        ->where('NIS', $nis)
        ->orderBy('minggu')
        ->get();

    return view('laporan-assesment.ortu', compact('siswa', 'assesments', 'kelas', 'tahunAjaran'));
}

public function edit($nis, $id_ta, $id_kelas, $minggu)
{
    $siswa = Siswa::where('NIS', $nis)->firstOrFail();
    $tahunAjaran = TahunAjaran::findOrFail($id_ta);
    $kelas = Kelas::findOrFail($id_kelas);

    return view('laporan_mingguan.edit', compact('siswa', 'tahunAjaran', 'kelas', 'minggu'));
}


public function showNotifyForm($nis, $id_ta, $id_kelas, $minggu)
{
    $siswa = Siswa::where('NIS', $nis)->firstOrFail();
    $tahunAjaran = TahunAjaran::findOrFail($id_ta);
    $kelas = Kelas::findOrFail($id_kelas);

    return view('laporan-assesment.edit', compact('siswa', 'tahunAjaran', 'kelas', 'minggu'));
}

public function sendNotification(Request $request, $nis, $id_ta, $id_kelas, $minggu)
{
    $request->validate([
        'pesan' => 'required|string',
    ]);

    $siswa = Siswa::where('NIS', $nis)->firstOrFail();

    DB::table('notifikasi')->insert([
        'judul' => 'Notifikasi Laporan Mingguan',
        'pesan' => $request->pesan,
        'untuk_role' => 'orangtua',
        'NIS' => $nis,
        'dibaca' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    return redirect()->route('laporan-assesment.showByKelas', [$id_kelas, $id_ta, $minggu])
                     ->with('success', 'Notifikasi berhasil dikirim ke orangtua!');
}


        public function cetakPdf($nis, $id_kelas, $id_ta, $minggu)
{
    $role = session('role');
    $nip = Auth::guard('guru')->user()->NIP ?? null;

    $wakel = WaliKelas::where('id_kelas', $id_kelas)
                    ->where('id_ta', $id_ta)
                    ->with('kelas', 'tahunAjaran')
                    ->firstOrFail();

    $anggota = AnggotaKelas::with('siswa')
        ->where('id_wakel', $wakel->id_wakel)
        ->where('NIS', $nis)
        ->firstOrFail();

    if ($role === 'wali_kelas' && $wakel->NIP !== $nip) {
        abort(403);
    } elseif ($role === 'orangtua') {
        $nisLogin = Auth::guard('siswa')->user()->NIS;
        if ($nis !== $nisLogin) {
            abort(403);
        }
    }

   $assesments = Assesment::where('NIS', $nis)
        ->where('minggu', $minggu)
        ->with('tujuan_pembelajaran')
        ->orderBy('minggu')
        ->get();

    $pdf = Pdf::loadView('laporan-assesment.pdf', [
        'siswa' => $anggota->siswa,
        'kelas' => $wakel->kelas,
        'tahunAjaran' => $wakel->tahunAjaran,
        'assesments' => $assesments
    ]);

    return $pdf->stream('laporan-assessment-' . $anggota->siswa->nama . '.pdf');
}
}


