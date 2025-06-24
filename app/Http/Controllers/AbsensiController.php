<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;

class AbsensiController extends Controller
{
    public function index(Request $request)
{
    $query = Absensi::with(['siswa', 'kelas', 'tahunAjaran'])->latest('tanggal');

    if ($request->has('search')) {
        $search = $request->search;
        $query->whereHas('siswa', function ($q) use ($search) {
            $q->where('nama_siswa', 'like', '%' . $search . '%')
              ->orWhere('NIS', 'like', '%' . $search . '%');
        });
    }

    $absensi = $query->get();

    return view('absensi.index', compact('absensi'));
}


    public function create()
{
    $siswa = Siswa::all();
    $kelas = Kelas::all();
    $tahun = TahunAjaran::all();

    // Ambil ID terakhir
    $last = Absensi::orderByDesc('id_absensi')->first();
    $lastNumber = $last ? (int) substr($last->id_absensi, 2) : 0;
    $newId = 'AB' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

    return view('absensi.form', compact('siswa', 'kelas', 'tahun', 'newId'));
}


public function store(Request $request)
{
    // Auto-generate ID
    $last = Absensi::orderByDesc('id_absensi')->first();
    $lastNumber = $last ? (int) substr($last->id_absensi, 2) : 0;
    $newId = 'AB' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

    $request->merge(['id_absensi' => $newId]);

    $request->validate([
        'id_absensi' => 'required|unique:absensi,id_absensi',
        'NIS' => 'required',
        'id_kelas' => 'required',
        'tanggal' => 'required|date',
        'STATUS' => 'required|in:Hadir,Sakit,Izin,Alpa',
        'id_ta' => 'required',
    ]);

    Absensi::create($request->all());
    return redirect()->route('absensi.index')->with('success', 'Data berhasil ditambahkan');
}


    public function edit($id_absensi)
    {
        $absensi = Absensi::findOrFail($id_absensi);
        $siswa = Siswa::all();
        $kelas = Kelas::all();
        $tahun = TahunAjaran::all();
        return view('absensi.form', compact('absensi', 'siswa', 'kelas', 'tahun'));
    }

    public function update(Request $request, $id_absensi)
    {
        $request->validate([
            'NIS' => 'required',
            'id_kelas' => 'required',
            'tanggal' => 'required|date',
            'STATUS' => 'required|in:Hadir,Sakit,Izin,Alpa',
            'id_ta' => 'required',
        ]);

        $absensi = Absensi::findOrFail($id_absensi);
        $absensi->update($request->all());

        return redirect()->route('absensi.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id_absensi)
    {
        Absensi::destroy($id_absensi);
        return redirect()->route('absensi.index')->with('success', 'Data berhasil dihapus');
    }
}
