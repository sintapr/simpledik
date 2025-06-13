<?php

namespace App\Http\Controllers;

use App\Models\Orangtua;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrangtuaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Orangtua::query();

        if ($search) {
            $query->where('NIS', 'like', "%{$search}%")
                  ->orWhere('nama_ayah', 'like', "%{$search}%");
        }

        $orangtua = $query->paginate(10);
        return view('orangtua.index', compact('orangtua'));
    }

    public function create()
{
    $lastOrtu = Orangtua::orderBy('id_ortu', 'desc')->first();

    if ($lastOrtu) {
        $lastNumber = (int) substr($lastOrtu->id_ortu, 2); // Ambil angka setelah "OT"
        $newId = 'OT' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newId = 'OT001';
    }

    $orangtua = new Orangtua();
    $orangtua->id_ortu = $newId;

    return view('orangtua.form', compact('orangtua'));
}


    public function store(Request $request)
{
    $request->validate([
        'id_ortu' => 'required|unique:orangtua,id_ortu|max:8',
        'NIS' => 'required|max:8',
        'nama_ayah' => 'required|max:155',
        'nama_ibu' => 'required|max:155',
        'pekerjaan_ayah' => 'nullable|max:50',
        'pekerjaan_ibu' => 'nullable|max:50',
        'alamat' => 'nullable|max:255',
    ]);

    // Ambil siswa berdasarkan NIS
    $siswa = \App\Models\Siswa::where('NIS', $request->NIS)->first();

    if (!$siswa) {
        return back()->withErrors(['NIS' => 'Siswa dengan NIS tersebut tidak ditemukan.'])->withInput();
    }

    // Password dari tanggal lahir siswa
    $passwordOrtu = \Carbon\Carbon::parse($siswa->tgl_lahir)->format('dmY');
    $hashedPasswordOrtu = \Illuminate\Support\Facades\Hash::make($passwordOrtu);

    // Generate ID Ortu baru
    $lastOrtu = \App\Models\Orangtua::orderBy('id_ortu', 'desc')->first();
    $newIdOrtu = $lastOrtu
        ? 'OT' . str_pad((int) substr($lastOrtu->id_ortu, 2) + 1, 3, '0', STR_PAD_LEFT)
        : 'OT001';

    // Simpan data
    \App\Models\Orangtua::create([
        'id_ortu' => $newIdOrtu,
        'NIS' => $request->NIS,
        'nama_ayah' => $request->nama_ayah ?? '-',
        'nama_ibu' => $request->nama_ibu ?? '-',
        'pekerjaan_ayah' => $request->pekerjaan_ayah,
        'pekerjaan_ibu' => $request->pekerjaan_ibu,
        'alamat' => $request->alamat,
        'password' => $hashedPasswordOrtu,
    ]);

    return redirect()->route('orangtua.index')->with('success', 'Data orang tua berhasil ditambahkan.');
}


    public function edit($id)
    {
        $orangtua = Orangtua::findOrFail($id);
        return view('orangtua.form', compact('orangtua'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NIS' => 'required|max:8',
            'nama_ayah' => 'required|max:155',
            'nama_ibu' => 'required|max:155',
            'pekerjaan_ayah' => 'nullable|max:50',
            'pekerjaan_ibu' => 'nullable|max:50',
            'alamat' => 'nullable|max:255',
        ]);

        $orangtua = Orangtua::findOrFail($id);
        $orangtua->update($request->except('id_ortu'));

        return redirect()->route('orangtua.index')->with('success', 'Data orang tua berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Orangtua::destroy($id);
        return redirect()->route('orangtua.index')->with('success', 'Data orang tua berhasil dihapus.');
    }
}
