<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Orangtua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    // Menampilkan daftar siswa dengan pagination dan pencarian
    public function index()
    {
        $siswa = Siswa::when(request('search'), function ($query) {
            $search = request('search');
            $query->where('nama_siswa', 'like', "%$search%")
                ->orWhere('NIS', 'like', "%$search%");
        })->paginate(10);

        return view('siswa.index', compact('siswa'));
    }

    // Form tambah siswa (buat objek kosong supaya blade aman)
    public function create()
    {
        $siswa = new Siswa();
        return view('siswa.form', compact('siswa'));
    }

    // Simpan data siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'NIS' => 'required|string|max:8|unique:siswa,NIS',
            'NISN' => 'nullable|string|max:12',
            'NIK' => 'nullable|string|max:12',
            'nama_siswa' => 'required|string|max:155',
            'tempat_lahir' => 'required|string|max:50',
            'tgl_lahir' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto_siswa', 'public');
        }

        // Simpan data siswa
        Siswa::create([
            'NIS' => $request->NIS,
            'NISN' => $request->NISN,
            'NIK' => $request->NIK,
            'nama_siswa' => $request->nama_siswa,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'foto' => $foto,
        ]);

        // Buat password dari tanggal lahir dan hash
        $passwordPlain = \Carbon\Carbon::parse($request->tgl_lahir)->format('dmY');
        $hashedPassword = Hash::make($passwordPlain);

        // Simpan data orangtua
           // Generate id_ortu baru
    $lastOrtu = Orangtua::orderBy('id_ortu', 'desc')->first();
    if ($lastOrtu) {
        $lastNumber = (int) substr($lastOrtu->id_ortu, 2);
        $newIdOrtu = 'OT' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newIdOrtu = 'OT001';
    }
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    // Tampilkan detail siswa
        public function show($NIS)
    {
        // Ambil data siswa beserta relasi yang dibutuhkan
        $siswa = Siswa::with([
            'orangtua',
            'anggota_kelas.waliKelas.guru',
            'anggota_kelas.waliKelas.kelas',
        ])->findOrFail($NIS);

        return view('siswa.show', compact('siswa'));
    }


    // Form edit siswa
    public function edit($NIS)
    {
        $siswa = Siswa::findOrFail($NIS);
        return view('siswa.form', compact('siswa'));
    }

    // Update data siswa
    public function update(Request $request, $NIS)
    {
        $siswa = Siswa::findOrFail($NIS);

        $request->validate([
            'NIS' => 'required|string|max:8|unique:siswa,NIS,' . $siswa->NIS . ',NIS',
            'NISN' => 'nullable|string|max:12',
            'NIK' => 'nullable|string|max:12',
            'nama_siswa' => 'required|string|max:155',
            'tempat_lahir' => 'required|string|max:50',
            'tgl_lahir' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto');

        // Jika ada file foto baru, simpan dan hapus foto lama
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            // Simpan foto baru
            $foto = $request->file('foto')->store('foto_siswa', 'public');
            $data['foto'] = $foto;
        }

        $siswa->update($data);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    // Hapus data siswa
    public function destroy($NIS)
    {
        $siswa = Siswa::findOrFail($NIS);

        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }
}
