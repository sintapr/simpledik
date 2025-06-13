<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Orangtua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        // Login sebagai Siswa
        // Login sebagai Siswa
        $siswa = Siswa::where('NIS', $credentials['identifier'])->first();

        if ($siswa) {
            $ortu = Orangtua::where('NIS', $siswa->NIS)->first();
            if ($ortu && Hash::check($credentials['password'], $ortu->password)) {
                Auth::guard('siswa')->login($siswa);
                session(['role' => 'siswa']);
                return redirect()->intended('/dashboard');
            }
        }

        // Login sebagai Guru
        $guru = Guru::where('NIP', $credentials['identifier'])->first();
        if ($guru && Hash::check($credentials['password'], $guru->password)) {
            Auth::guard('guru')->login($guru);
            session(['role' => strtolower($guru->jabatan)]); // admin, wali_kelas, kepala_sekolah
            return redirect()->intended('/dashboard');
        }

        // 🔥 Login sebagai Orangtua
        // Login sebagai Orangtua
    $ortu = Orangtua::where('NIS', $credentials['identifier'])->first();
    if ($ortu && Hash::check($credentials['password'], $ortu->password)) {
        Auth::guard('orangtua')->login($ortu);
        session(['role' => 'orangtua']);
        return redirect()->intended('/dashboard');
    }

        return back()->withErrors(['identifier' => 'NIS/NIP atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        session()->flush(); // hapus semua session
        return redirect('/login'); // atau route loginmu
    }
}
