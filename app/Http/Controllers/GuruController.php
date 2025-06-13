<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Guru::query();

        if ($search) {
            $query->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('NIP', 'like', "%{$search}%");
        }

        $guru = $query->paginate(10);

        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.form', ['guru' => new Guru()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'NIP' => 'required|string|max:12|unique:guru,NIP',
            'nama_guru' => 'required|string|max:155',
            'jabatan' => 'required|in:kepala_sekolah,wali_kelas,admin',
            'tgl_lahir' => 'required|date',
            'foto' => 'nullable|image|max:2048',
            'status' => 'required|in:1,0',
        ]);

        $tanggalLahir = Carbon::parse($request->tgl_lahir)->format('dmY');
        $hashedPassword = Hash::make($tanggalLahir); // Default password: ddmmyyyy

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto_guru', 'public');
        }

        Guru::create([
            'NIP' => $request->NIP,
            'nama_guru' => $request->nama_guru,
            'jabatan' => $request->jabatan,
            'tgl_lahir' => $request->tgl_lahir,
            'foto' => $foto,
            'password' => $hashedPassword,
            'status' => $request->status,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($NIP)
    {
        $guru = Guru::findOrFail($NIP);
        return view('guru.form', compact('guru'));
    }

    public function show($NIP)
    {
        $guru = Guru::findOrFail($NIP);
        return view('guru.show', compact('guru'));
    }

    public function update(Request $request, $NIP)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:155',
            'jabatan' => 'required|in:kepala_sekolah,wali_kelas,admin',
            'tgl_lahir' => 'required|date',
            'foto' => 'nullable|image|max:2048',
            'PASSWORD' => 'nullable|min:8',
            'status' => 'required|in:1,0',

        ]);

        $guru = Guru::findOrFail($NIP);

        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }
            $guru->foto = $request->file('foto')->store('foto_guru', 'public');
        }

        if ($request->filled('PASSWORD')) {
            $guru->password = Hash::make($request->PASSWORD);
        }

        $guru->nama_guru = $request->nama_guru;
        $guru->jabatan = $request->jabatan;
        $guru->tgl_lahir = $request->tgl_lahir;
        $guru->status = $request->status;
        $guru->save();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($NIP)
    {
        $guru = Guru::findOrFail($NIP);

        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    public function profil()
    {
        $guru = Auth::guard('guru')->user();
        return view('guru.profil', compact('guru'));
    }
}
