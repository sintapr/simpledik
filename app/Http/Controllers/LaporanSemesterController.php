<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use App\Models\MonitoringSemester;
use App\Models\Absensi;
use App\Models\KondisiSiswa;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LaporanSemesterController extends Controller
{
    // Menampilkan daftar kelas dengan jumlah siswa per tahun ajaran yang dipilih atau aktif
public function index(Request $request)
{
    $search = $request->input('search');

    $tahunAjarans = TahunAjaran::when($search, function ($query, $search) {
            return $query->where('semester', 'like', "%$search%")
                        ->orWhere('tahun_mulai', 'like', "%$search%");
        })
        ->orderBy('tahun_mulai')
        ->orderBy('semester')
        ->get();

    // Deteksi user dan role berdasarkan guard
    if (Auth::guard('siswa')->check()) {
        $user = Auth::guard('siswa')->user();
        $role = 'orangtua';
    } elseif (Auth::guard('guru')->check()) {
        $user = Auth::guard('guru')->user();
        $role = $user->jabatan ?? 'guest';
    } else {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    // ======== Jika ORANGTUA, langsung tampilkan daftar rapor anak ========
    if ($role === 'orangtua') {
        $raporSemester = MonitoringSemester::where('NIS', $user->NIS)
            ->with(['tahunAjaran', 'kelas'])
            ->get();

        $siswa = \App\Models\Siswa::where('NIS', $user->NIS)->first();

        return view('laporan-semester.ortu', compact('raporSemester', 'siswa'));
    }

    // ======== Jika GURU / ADMIN / WALI_KELAS ========
    $kelasList = [];

    if ($role === 'wali_kelas') {
        $waliKelasList = WaliKelas::where('NIP', $user->NIP)
                            ->whereIn('id_ta', $tahunAjarans->pluck('id_ta'))
                            ->with('kelas')
                            ->get();

    } elseif (in_array($role, ['admin', 'kepala_sekolah'])) {
        $waliKelasList = WaliKelas::whereIn('id_ta', $tahunAjarans->pluck('id_ta'))
                            ->with('kelas')
                            ->get();

    } else {
        return abort(403, 'Akses ditolak.');
    }

    foreach ($waliKelasList as $wali) {
        if ($wali && $wali->kelas) {
            $jumlah = $wali->anggotaKelas()->count(); // relasi anggotaKelas harus ada
            $kelasList[] = [
                'kelas' => $wali->kelas,
                'jumlah_siswa' => $jumlah,
                'semester' => $wali->tahunAjaran->semester ?? '-',
                'tahun_ajaran' => $wali->tahunAjaran->tahun_mulai ?? '-',
                'status' => $wali->tahunAjaran->status ?? 0,
                'id_wakel' => $wali->id_wakel,
                'id_ta' => $wali->id_ta,
            ];
        }
    }

    $kelasList = collect($kelasList)->sortBy([
        ['tahun_ajaran', 'asc'],
        ['semester', 'asc'],
    ])->values()->all();

    return view('laporan-semester.index', compact('kelasList', 'tahunAjarans'));
}


    // Menampilkan detail wali kelas dan daftar siswa di kelas tersebut untuk tahun ajaran aktif
       public function detail($id_kelas, $id_ta = null)
{
    if (!$id_ta) {
        // Ambil tahun ajaran aktif, atau tahun ajaran terakhir jika tidak ada yg aktif
        $tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first();

        if (!$tahunAjaranAktif) {
            $tahunAjaranAktif = TahunAjaran::orderByDesc('id_ta')->first();
        }

        if (!$tahunAjaranAktif) {
            return redirect()->route('laporan-semester.index')->with('error', 'Tahun ajaran tidak ditemukan.');
        }

        $id_ta = $tahunAjaranAktif->id_ta;
    }

    $waliKelasList = WaliKelas::with(['kelas', 'guru', 'tahunAjaran'])
        ->where('id_kelas', $id_kelas)
        ->where('id_ta', $id_ta)
        ->get();

    if ($waliKelasList->isEmpty()) {
        return redirect()->route('laporan-semester.index')->with('error', 'Data tidak ditemukan.');
    }

    return view('laporan-semester.detail', compact('waliKelasList'));
}






    // Menampilkan halaman laporan rapor semester siswa
    public function show($nis, $id_ta, $semester)
{
    $tahunAjaran = TahunAjaran::findOrFail($id_ta);

    // Pastikan semester yang diminta sama dengan semester di tahun ajaran
    if ($tahunAjaran->semester != $semester) {
        abort(404, 'Semester tidak ditemukan untuk tahun ajaran ini.');
    }

    $siswa = Siswa::with('orangtua')->findOrFail($nis);

    // Query MonitoringSemester berdasarkan nis dan id_ta saja
    $rapor = MonitoringSemester::with([
        'detailNilaiHafalan.surat',
        'detailNilaiTarbiyah.materi',
        'detailNilaiCp.penilaian.perkembangan',
        'detailNilaiP5.perkembangan',
        'kelas',    // kalau perlu relasi kelas
        'guru',     // kalau perlu relasi guru
        'fase'      // kalau perlu relasi fase
    ])
    ->where('NIS', $nis)
    ->where('id_ta', $id_ta)
    ->first();

    if (!$rapor) {
        abort(404, 'Rapor belum tersedia untuk semester ini.');
    }

    // ... lanjutkan seperti biasa
    $hafalan = $rapor->detailNilaiHafalan ?? collect();
    $tarbiyah = $rapor->detailNilaiTarbiyah ?? collect();
    $cp = $rapor->detailNilaiCp ?? collect();
    $p5 = $rapor->detailNilaiP5 ?? collect();

    // Ambil absensi dan lainnya seperti sebelumnya
    $absensi = Absensi::where('NIS', $nis)
        ->where('id_ta', $id_ta)
        ->get();

    $rekap_absen = [
        'sakit' => $absensi->where('STATUS', 'Sakit')->count(),
        'izin'  => $absensi->where('STATUS', 'Izin')->count(),
        'alpa'  => $absensi->where('STATUS', 'Alpa')->count(),
    ];

    $kondisi = KondisiSiswa::where('NIS', $nis)
        ->where('id_ta', $id_ta)
        ->first();

    $muqoddimah = view('laporan-semester.muqoddimah')->render();

    return view('laporan-semester.show', compact(
        'siswa', 'muqoddimah', 'rekap_absen', 'hafalan', 'tarbiyah', 'cp', 'p5', 'kondisi', 'tahunAjaran', 'rapor'
    ));
}

public function ortu()
{
    $ortu = Auth::guard('orangtua')->user(); // pakai guard 'orangtua'
    $nis = $ortu->NIS; // ambil NIS dari kolom di tabel orangtua

    $siswa = Siswa::where('NIS', $nis)->firstOrFail();

    $raporSemester = MonitoringSemester::with(['tahunAjaran', 'kelas'])
        ->where('NIS', $nis)
        ->orderByDesc('id_ta')
        ->get();

    return view('laporan-semester.ortu', compact('siswa', 'raporSemester'));
}







        public function rapor($id_kelas, $id_ta)
    {
        $kelas = Kelas::findOrFail($id_kelas);
        $ta = TahunAjaran::findOrFail($id_ta);

        $data = MonitoringSemester::with('siswa')
            ->where('id_kelas', $id_kelas)
            ->where('id_ta', $id_ta)
            ->get();

        return view('laporan-semester.rapor', compact('data', 'kelas', 'ta'));
    }

public function edit($nis, $id_ta)
{
    $siswa = Siswa::findOrFail($nis);
    $tahunAjaran = TahunAjaran::findOrFail($id_ta);

    // Ambil id_kelas dari monitoring_semester (atau tabel lain yang sesuai)
    $id_kelas = MonitoringSemester::where('NIS', $nis)
                ->where('id_ta', $id_ta)
                ->value('id_kelas');

    return view('laporan-semester.edit', compact('siswa', 'tahunAjaran', 'id_kelas'));
}







    // Cetak rapor semester siswa dalam format PDF
   public function cetakRapor($nis, $id_ta, $semester)
{
    $tahunAjaran = TahunAjaran::findOrFail($id_ta);

    if ($tahunAjaran->semester != $semester) {
        abort(404, 'Semester tidak sesuai.');
    }

    

    $siswa = Siswa::with('orangtua')->findOrFail($nis);

    $rapor = MonitoringSemester::with([
        'detailNilaiHafalan.surat',
        'detailNilaiTarbiyah.materi.indikator',
        'detailNilaiCp.penilaian.perkembangan',
        'detailNilaiP5.perkembangan',
        'kelas', 'fase', 'guru', 'tahunAjaran'
    ])
    ->where('NIS', $nis)
    ->where('id_ta', $id_ta)
    ->first();

    if (!$rapor) {
        abort(404, 'Rapor belum tersedia untuk semester ini.');
    }

    $hafalan = $rapor->detailNilaiHafalan ?? collect();
    $tarbiyah = $rapor->detailNilaiTarbiyah ?? collect();
    $cp = $rapor->detailNilaiCp ?? collect();
    $p5 = $rapor->detailNilaiP5 ?? collect();

    $absensi = Absensi::where('NIS', $nis)
        ->where('id_ta', $id_ta)
        ->get();

    $rekap_absen = [
        'sakit' => $absensi->where('STATUS', 'Sakit')->count(),
        'izin'  => $absensi->where('STATUS', 'Izin')->count(),
        'alpa'  => $absensi->where('STATUS', 'Alpa')->count(),
    ];

    $kondisi = KondisiSiswa::where('NIS', $nis)
        ->where('id_ta', $id_ta)
        ->first();

    $muqoddimah = view('laporan-semester.muqoddimah')->render();

    $filename = 'Rapor_' . Str::slug($siswa->nama_siswa) . "_Semester{$semester}.pdf";

   $pdf = Pdf::loadView('laporan-semester.rapor_pdf', compact(
    'siswa', 'rapor', 'hafalan', 'tarbiyah', 'cp', 'p5',
    'rekap_absen', 'kondisi', 'muqoddimah', 'semester', 'tahunAjaran'
));


    return $pdf->stream($filename);
}

public function notify(Request $request, $nis, $id_ta, $id_kelas)
{

        $user = Auth::user();

    if (!in_array($user->jabatan, ['admin', 'wali_kelas'])) {
        abort(403, 'Anda tidak memiliki izin untuk mengirim notifikasi.');
    }

    $request->validate([
        'pesan' => 'required|string',
    ]);

    // Validasi apakah NIS benar-benar ada
    if (!DB::table('siswa')->where('NIS', $nis)->exists()) {
        return back()->with('error', 'Siswa tidak ditemukan.');
    }

    DB::table('notifikasi')->insert([
        'judul' => 'Notifikasi Rapor Semester',
        'pesan' => $request->pesan,
        'untuk_role' => 'orangtua',
        'NIS' => $nis,
        'dibaca' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('laporan-semester.rapor', ['id_kelas' => $id_kelas, 'id_ta' => $id_ta])
        ->with('success', 'Notifikasi berhasil dikirim ke orangtua.');
}


}
