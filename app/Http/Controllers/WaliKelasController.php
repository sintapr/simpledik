<?php

namespace App\Http\Controllers;

use App\Models\WaliKelas;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class WaliKelasController extends Controller
{
    public function index(Request $request)
{
    $tahunAjaranAktif = TahunAjaran::where('status', 1)->first();
    $tahunAjaranList = TahunAjaran::all();

    $id_ta = $request->input('id_ta', $tahunAjaranAktif->id_ta ?? null);
    $search = $request->search;

    $query = WaliKelas::with(['guru', 'kelas', 'tahunAjaran'])
        ->where('id_ta', $id_ta);

    if ($search) {
        $query->whereHas('guru', function ($q) use ($search) {
            $q->where('nama_guru', 'like', '%' . $search . '%');
        });
    }

    $waliKelas = $query->paginate(10); // Ini saja, tidak ditimpa lagi

    return view('wali_kelas.index', compact('waliKelas', 'tahunAjaranList', 'id_ta'));
}



    public function create()
    {
        $last = WaliKelas::orderBy('id_wakel', 'desc')->first();
        if ($last) {
            $lastNumber = (int) substr($last->id_wakel, 2);
            $nextId = 'WK' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextId = 'WK001';
        }
        $kelas = Kelas::all();
        $guru = Guru::all();
        $tahunAjaran = TahunAjaran::all();
        return view('wali_kelas.form', [
            'waliKelas' => new WaliKelas(),
            'guru' => $guru,
            'kelas' => $kelas,
            'tahunAjaran' => $tahunAjaran,
            'isEdit' => false,
            'nextId' => $nextId
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_wakel' => 'required|unique:wali_kelas,id_wakel',
            'NIP' => 'required|exists:guru,NIP',
            'id_ta' => 'required|exists:tahun_ajaran,id_ta',
            'id_kelas' => 'required|exists:kelas,id_kelas',
        ]);

        WaliKelas::create($request->all());
        return redirect()->route('wali_kelas.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        $guru = Guru::all();
        $kelas = Kelas::all();
        $tahunAjaran = TahunAjaran::all();
    
        return view('wali_kelas.form', [
            'waliKelas' => $waliKelas,
            'guru' => $guru,
            'kelas'=> $kelas,
            'tahunAjaran' => $tahunAjaran,
            'isEdit' => true,
            'nextId' => null, // opsional, karena tidak dipakai saat edit
        ]);
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'NIP' => 'required|exists:guru,NIP',
            'id_ta' => 'required|exists:tahun_ajaran,id_ta',
            'id_kelas' => 'required|exists:kelas,id_kelas',
        ]);

        $waliKelas = WaliKelas::findOrFail($id);
        $waliKelas->update($request->all());

        return redirect()->route('wali_kelas.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        WaliKelas::destroy($id);
        return redirect()->route('wali_kelas.index')->with('success', 'Data berhasil dihapus.');
    }
}
