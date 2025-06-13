<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    // Tampilkan notifikasi untuk orangtua yang sedang login
    public function index()
    {
        $nis = Auth::user()->NIS; // asumsi orangtua login via siswa dan punya NIS

        // Ambil notifikasi untuk orangtua yang spesifik (NIS) dan notifikasi massal (NIS null)
        $notifikasi = Notifikasi::where('untuk_role', 'orangtua')
            ->where(function($query) use ($nis) {
                $query->whereNull('NIS')
                      ->orWhere('NIS', $nis);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifikasi.index', compact('notifikasi'));
    }

    // Tandai notifikasi sudah dibaca (via ajax misalnya)
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->dibaca = true;
        $notifikasi->save();

        return response()->json(['status' => 'success']);
    }

    public function kirimLaporanSemester(Request $request)
{
    $request->validate([
        'id_kelas' => 'required',
        'id_ta' => 'required',
        'jenis' => 'required|in:semester,mingguan',
    ]);

    // Ambil semua siswa di kelas dan tahun ajaran tersebut
    $siswaList = DB::table('anggota_kelas')
        ->where('id_kelas', $request->id_kelas)
        ->where('id_ta', $request->id_ta)
        ->pluck('NIS');

    foreach ($siswaList as $nis) {
        DB::table('notifikasi')->insert([
            'judul' => 'Laporan ' . ucfirst($request->jenis) . ' Tersedia',
            'pesan' => 'Laporan ' . $request->jenis . ' anak Anda sudah tersedia dan dapat dilihat pada sistem.',
            'untuk_role' => 'orangtua',
            'NIS' => $nis,
            'dibaca' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return back()->with('success', 'Notifikasi berhasil dikirim ke orangtua.');
}

public function kirimLaporanMingguan(Request $request)
{
    $request->validate([
        'id_kelas' => 'required',
        'id_ta' => 'required',
        'minggu' => 'required|integer',
    ]);

    $nip = Auth::user()->NIP;

    // Pastikan user yang login adalah wali kelas dari kelas dan tahun ajaran ini
    $isWali = DB::table('wali_kelas')
        ->where('id_kelas', $request->id_kelas)
        ->where('id_ta', $request->id_ta)
        ->where('NIP', $nip)
        ->exists();

    if (!$isWali && session('role') !== 'admin') {
        return back()->with('error', 'Anda bukan wali kelas dari kelas ini.');
    }

    // Ambil semua siswa di kelas tersebut
    $siswaList = DB::table('anggota_kelas')
        ->where('id_kelas', $request->id_kelas)
        ->where('id_ta', $request->id_ta)
        ->pluck('NIS');

    foreach ($siswaList as $nis) {
        DB::table('notifikasi')->insert([
            'judul' => 'Laporan Mingguan Minggu ke-' . $request->minggu,
            'pesan' => 'Laporan perkembangan anak Anda untuk minggu ke-' . $request->minggu . ' sudah tersedia.',
            'untuk_role' => 'orangtua',
            'NIS' => $nis,
            'dibaca' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return back()->with('success', 'Notifikasi mingguan berhasil dikirim ke semua orangtua di kelas ini.');
}


public function kirimPerSiswa(Request $request, $nis, $id_ta)
{
    $request->validate([
        'pesan' => 'required|string',
    ]);

    DB::table('notifikasi')->insert([
        'judul' => 'Notifikasi Rapor Semester',
        'pesan' => $request->pesan,
        'untuk_role' => 'orangtua',
        'NIS' => $nis,
        'dibaca' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('laporan-semester.rapor', [$request->id_kelas, $id_ta])
        ->with('success', 'Notifikasi berhasil dikirim ke orangtua.');
}




}
