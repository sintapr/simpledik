<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
{

    $search = $request->input('search');

    $query = Kelas::query();

   if ($search) {
            $query->where('id_kelas', 'like', "%{$search}%")
                  ->orWhere('nama_kelas', 'like', "%{$search}%");
   }

    $kelas = $query->paginate(10);

    return view('kelas.index', compact('kelas'));
}


    public function create()
    {
        $lastKelas = Kelas::orderBy('id_kelas', 'desc')->first();

        if ($lastKelas) {
            $lastNumber = (int) substr($lastKelas->id_kelas, 1); // ambil angka setelah "K"
            $newId = 'K' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newId = 'K001';
        }

        $kelas = new Kelas();
        $kelas->id_kelas = $newId;

        return view('kelas.form', compact('kelas', 'newId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required|string|max:8|unique:kelas',
            'nama_kelas' => 'nullable|string|max:6',
        ]);

        Kelas::create($request->only('id_kelas', 'nama_kelas'));

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit($id_kelas)
    {
        $kelas = Kelas::findOrFail($id_kelas);
        return view('kelas.form', compact('kelas'));
    }

    public function update(Request $request, $id_kelas)
    {
        $kelas = Kelas::findOrFail($id_kelas);

        $request->validate([
            'nama_kelas' => 'nullable|string|max:6',
        ]);

        // Jangan update id_kelas agar tidak berubah
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy($id_kelas)
    {
        $kelas = Kelas::findOrFail($id_kelas);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
