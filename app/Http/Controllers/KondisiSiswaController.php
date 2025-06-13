<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KondisiSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;

class KondisiSiswaController extends Controller
{
    public function index()
    {
        $kondisi = KondisiSiswa::with('siswa', 'tahunAjaran')->get();
        return view('kondisi_siswa.index', compact('kondisi'));
    }

        public function create()
    {
        $siswa = Siswa::all();
        $tahun = TahunAjaran::all();

        // Generate ID otomatis
        $last = KondisiSiswa::orderByDesc('id_kondisi')->first();
        $lastNumber = $last ? (int) substr($last->id_kondisi, 2) : 0;
        $newId = 'KS' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Objek kosong untuk form
        $data = new KondisiSiswa();
        $data->id_kondisi = $newId;

        return view('kondisi_siswa.form', compact('data', 'siswa', 'tahun'));
    }

        public function store(Request $request)
    {
        // Generate ID otomatis
        $last = KondisiSiswa::orderByDesc('id_kondisi')->first();
        $lastNumber = $last ? (int) substr($last->id_kondisi, 2) : 0;
        $newId = 'KS' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        $request->merge(['id_kondisi' => $newId]);

        $request->validate([
            'id_kondisi' => 'required|unique:kondisi_siswa',
            'NIS' => 'required',
            'penglihatan' => 'required',
            'pendengaran' => 'required',
            'gigi' => 'required',
            'id_ta' => 'required',
        ]);

        KondisiSiswa::create($request->all());
        return redirect()->route('kondisi-siswa.index')->with('success', 'Data berhasil ditambahkan.');
    }


    public function edit($id_kondisi)
    {
        $data = KondisiSiswa::findOrFail($id_kondisi);
        $siswa = Siswa::all();
        $tahun = TahunAjaran::all();
        return view('kondisi_siswa.form', compact('data', 'siswa', 'tahun'));
    }

    public function update(Request $request, $id_kondisi)
    {
        $data = KondisiSiswa::findOrFail($id_kondisi);
        $data->update($request->all());
        return redirect()->route('kondisi-siswa.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id_kondisi)
    {
        $data = KondisiSiswa::findOrFail($id_kondisi);
        $data->delete();
        return redirect()->route('kondisi-siswa.index')->with('success', 'Data berhasil dihapus.');
    }
}

