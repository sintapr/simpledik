<?php

namespace App\Http\Controllers;

use App\Models\PenilaianCp;
use App\Models\Perkembangan;
use Illuminate\Http\Request;

class PenilaianCpController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $penilaian = PenilaianCp::with('perkembangan')
        ->when($search, function ($query, $search) {
            $query->where('aspek_nilai', 'like', '%' . $search . '%')
                  ->orWhereHas('perkembangan', function ($q) use ($search) {
                      $q->where('indikator', 'like', '%' . $search . '%');
                  });
        })
        ->orderBy('id_penilaian_cp')
        ->paginate(10);

    return view('penilaian_cp.index', compact('penilaian'));
}
        public function create()
    {
        $lastId = PenilaianCp::max('id_penilaian_cp');
        $newId = 'PC001';
        if ($lastId) {
            $number = (int) substr($lastId, 2);
            $newId = 'PC' . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('penilaian_cp.form', [
            'penilaian' => new PenilaianCp(['id_penilaian_cp' => $newId]),
            'perkembangan' => Perkembangan::all(),
            'action' => route('penilaian_cp.store'),
            'method' => 'POST'
        ]);
    }


        public function store(Request $request)
    {
        $request->validate([
            'id_perkembangan' => 'required',
            'aspek_nilai' => 'required'
        ]);

        // Generate ID otomatis
        $lastId = PenilaianCp::orderBy('id_penilaian_cp', 'desc')->first();
        if ($lastId) {
            $number = (int) substr($lastId->id_penilaian_cp, 2) + 1;
        } else {
            $number = 1;
        }
        $newId = 'PC' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Simpan data
        PenilaianCp::create([
            'id_penilaian_cp' => $newId,
            'id_perkembangan' => $request->id_perkembangan,
            'aspek_nilai' => $request->aspek_nilai
        ]);

        return redirect()->route('penilaian_cp.index')->with('success', 'Data berhasil ditambahkan');
    }


    public function edit($id_penilaian_cp)
    {
        $penilaian = PenilaianCp::findOrFail($id_penilaian_cp);
        return view('penilaian_cp.form', [
            'penilaian' => $penilaian,
            'perkembangan' => Perkembangan::all(),
            'action' => route('penilaian_cp.update', $penilaian->id_penilaian_cp),
            'method' => 'PUT'
        ]);
    }

    public function update(Request $request, $id_penilaian_cp)
    {
        $penilaian = PenilaianCp::findOrFail($id_penilaian_cp);
        $penilaian->update($request->all());
        return redirect()->route('penilaian_cp.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id_penilaian_cp)
    {
        PenilaianCp::destroy($id_penilaian_cp);
        return redirect()->route('penilaian_cp.index')->with('success', 'Data berhasil dihapus');
    }
}
