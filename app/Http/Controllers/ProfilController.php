<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function show()
    {
        if (Auth::guard('guru')->check()) {
            $user = Auth::guard('guru')->user();
            $role = strtolower($user->jabatan);
            return view('profil.guru', compact('user', 'role'));
        } elseif (Auth::guard('siswa')->check()) {
            $user = Auth::guard('siswa')->user();
            $role = 'ortu';
            return view('profil.siswa', compact('user', 'role'));
        }

        return redirect()->route('login');
    }

    public function update(Request $request)
    {
        if (Auth::guard('guru')->check()) {
            $user = Auth::guard('guru')->user();

            $user->nama_guru = $request->nama_guru;
            $user->tgl_lahir = $request->tgl_lahir;

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('foto', 'public');
                $user->foto = $path;
            }

            // $user->save();

            return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui.');
        }

        return back()->with('error', 'Tidak diizinkan.');
    }
    public function edit()
{
    if (Auth::guard('guru')->check()) {
        $user = Auth::guard('guru')->user();
        $role = strtolower($user->jabatan);
        return view('profil.edit-guru', compact('user', 'role'));
    }

    if (Auth::guard('siswa')->check()) {
        $user = Auth::guard('siswa')->user();
        $role = strtolower($user->ortu);
        return view('profil.edit-ortu', compact('user', 'role'));
    }

    return back()->with('error', 'Akses tidak diizinkan.');
}

}
