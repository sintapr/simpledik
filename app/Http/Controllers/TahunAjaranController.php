<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        $query = TahunAjaran::query();

        if ($search = $request->input('search')) {
            $query->where('semester', 'like', "%{$search}%")
                ->orWhere('tahun_mulai', 'like', "%{$search}%");
        }

        // Urutkan berdasarkan angka dari id_ta
        $tahunAjaran = $query
            ->orderByRaw("CAST(SUBSTRING(id_ta, 3) AS UNSIGNED) ASC")
            ->paginate(10);

        // Ambil ID terakhir juga dengan urutan angka
        $last = TahunAjaran::orderByRaw("CAST(SUBSTRING(id_ta, 3) AS UNSIGNED) DESC")->first();
        if ($last) {
            $lastNumber = (int) substr($last->id_ta, 2);
            $nextId = 'TA' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextId = 'TA001';
        }

        return view('tahun-ajaran.index', compact('tahunAjaran', 'nextId'));
    }

    public function create()
    {
        $last = TahunAjaran::orderByRaw("CAST(SUBSTRING(id_ta, 3) AS UNSIGNED) DESC")->first();
        if ($last) {
            $lastNumber = (int) substr($last->id_ta, 2);
            $nextId = 'TA' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextId = 'TA001';
        }

        return view('tahun-ajaran.form', ['tahunAjaran' => new TahunAjaran(), 'nextId' => $nextId]);
    }

        public function store(Request $request)
    {
        $request->validate([
            'id_ta' => 'required|unique:tahun_ajaran,id_ta',
            'semester' => 'required|in:1,2',
            'tahun_ajaran' => ['required', 'regex:/^\d{4}\/\d{4}$/'],
            'status' => 'required|in:1,0',
        ]);

        [$tahun_mulai, $tahun_selesai] = explode('/', $request->tahun_ajaran);

        if ((int)$tahun_selesai !== (int)$tahun_mulai + 1) {
            return back()->withErrors(['tahun_ajaran' => 'Tahun kedua harus satu tahun setelah tahun pertama.'])->withInput();
        }

        TahunAjaran::create([
            'id_ta' => $request->id_ta,
            'semester' => $request->semester,
            'tahun_mulai' => $tahun_mulai,
            'status' => $request->status,
        ]);

        return redirect()->route('tahun-ajaran.index')->with('success', 'Data berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return view('tahun-ajaran.form', compact('tahunAjaran'));
    }

        public function update(Request $request, $id)
    {
        $request->validate([
            'semester' => 'required|in:1,2',
            'tahun_ajaran' => ['required', 'regex:/^\d{4}\/\d{4}$/'],
            'status' => 'required|in:1,0',
        ]);

        [$tahun_mulai, $tahun_selesai] = explode('/', $request->tahun_ajaran);

        if ((int)$tahun_selesai !== (int)$tahun_mulai + 1) {
            return back()->withErrors(['tahun_ajaran' => 'Tahun kedua harus satu tahun setelah tahun pertama.'])->withInput();
        }

        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->update([
            'semester' => $request->semester,
            'tahun_mulai' => $tahun_mulai,
            'status' => $request->status,
        ]);

        return redirect()->route('tahun-ajaran.index')->with('success', 'Data berhasil diupdate.');
    }

}
