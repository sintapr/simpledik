<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKelas;
use App\Models\Siswa;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggotaKelasController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjaranList = TahunAjaran::orderByDesc('tahun_mulai')->orderByDesc('semester')->get();
        $id_ta = $request->get('id_ta') ?? TahunAjaran::where('status', 1)->value('id_ta');

        $anggotaKelas = AnggotaKelas::with(['siswa', 'waliKelas.guru', 'waliKelas.tahunAjaran'])
            ->whereHas('waliKelas', function ($query) use ($id_ta) {
                $query->where('id_ta', $id_ta);
            })
            ->get();

            $query = AnggotaKelas::with(['siswa', 'waliKelas.guru', 'waliKelas.tahunAjaran'])
            ->whereHas('waliKelas', function ($q) use ($id_ta) {
                $q->where('id_ta', $id_ta);
            });

            if ($search = $request->input('search')) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('NIS', 'like', '%' . $search . '%');
            });
        }

        $anggotaKelas = $query->paginate(10);


        return view('anggota_kelas.index', compact('anggotaKelas', 'tahunAjaranList', 'id_ta'));
    }

    public function create()
    {
        $siswaList = Siswa::all();
        $waliKelasList = WaliKelas::with('guru', 'tahunAjaran')->get();
        $tahunAjaranList = TahunAjaran::orderByDesc('tahun_mulai')->orderByDesc('semester')->get();
        $id_ta_aktif = TahunAjaran::where('status', 1)->first();

        // Cari tahun ajaran sebelumnya
        $taSebelumnya = TahunAjaran::where(function($q) use ($id_ta_aktif) {
            $q->where('tahun_mulai', '<', $id_ta_aktif->tahun_mulai)
              ->orWhere(function($q2) use ($id_ta_aktif) {
                  $q2->where('tahun_mulai', $id_ta_aktif->tahun_mulai)
                     ->where('semester', '<', $id_ta_aktif->semester);
              });
        })
        ->orderByDesc('tahun_mulai')
        ->orderByDesc('semester')
        ->first();

        $anggotaSebelumnya = [];
        if ($taSebelumnya) {
            $anggotaSebelumnya = AnggotaKelas::with(['waliKelas.guru', 'waliKelas.tahunAjaran'])
                ->whereHas('waliKelas', function ($q) use ($taSebelumnya) {
                    $q->where('id_ta', $taSebelumnya->id_ta);
                })
                ->get()
                ->groupBy('NIS');
        }

        return view('anggota_kelas.form', compact('siswaList', 'waliKelasList', 'tahunAjaranList', 'anggotaSebelumnya'));
    }

        public function store(Request $request)
    {
        $request->validate([
            'id_wakel' => 'required',
            'siswa_ids' => 'required|array',
        ]);

        // Ambil ID terakhir dari database
        $lastId = AnggotaKelas::orderBy('id_anggota', 'desc')->value('id_anggota');
        $lastNumber = $lastId ? (int) substr($lastId, 2) : 0;

        $dataToInsert = [];

        foreach ($request->siswa_ids as $index => $nis) {
            $newNumber = $lastNumber + $index + 1;
            $newId = 'AG' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

            $dataToInsert[] = [
                'id_anggota' => $newId,
                'NIS' => $nis,
                'id_wakel' => $request->id_wakel,
            ];
        }

        // Masukkan semua data sekaligus
        AnggotaKelas::insert($dataToInsert);

        return redirect()->route('anggota_kelas.index')->with('success', 'Siswa berhasil dimasukkan ke kelas');
    }


    public function destroy($id)
    {
        AnggotaKelas::where('id_anggota', $id)->delete();
        return redirect()->back()->with('success', 'Siswa berhasil dihapus dari kelas');
    }

}
