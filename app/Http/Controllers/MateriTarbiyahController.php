<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MateriTarbiyah;
use App\Models\IndikatorTarbiyah;

class MateriTarbiyahController extends Controller
{
    public function index(Request $request)
{
    $query = MateriTarbiyah::with('indikator');

    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('materi', 'like', "%$search%")
              ->orWhereHas('indikator', function($q2) use ($search) {
                  $q2->where('indikator', 'like', "%$search%");
              });
        });
    }

    $materi = $query->paginate(10);

    return view('materi_tarbiyah.index', compact('materi'));
}


    public function create()
{
    $indikator = IndikatorTarbiyah::all();

    // Buat ID otomatis: MT001, MT002, ...
    $last = MateriTarbiyah::orderByDesc('id_materi')->first();
    $lastNumber = $last ? (int) substr($last->id_materi, 2) : 0;
    $newId = 'MT' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

    // Buat objek kosong dan isi ID default
    $materi = new MateriTarbiyah();
    $materi->id_materi = $newId;
    

    return view('materi_tarbiyah.form', compact('materi', 'indikator'));
}


public function store(Request $request)
{
    $last = MateriTarbiyah::orderByDesc('id_materi')->first();
    $lastNumber = $last ? (int) substr($last->id_materi, 2) : 0;
    $newId = 'MT' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

    $request->validate([
        'materi' => 'required',
        'id_indikator' => 'required|exists:indikator_tarbiyah,id_indikator',
        'semester' => 'required',
        'status' => 'required|in:1,0',
    ]);

    MateriTarbiyah::create([
        'id_materi' => $newId,
        'materi' => $request->materi,
        'id_indikator' => $request->id_indikator,
        'semester' => $request->semester,
        'status' => $request->status,
    ]);

    return redirect()->route('materi_tarbiyah.index')->with('success', 'Data berhasil ditambahkan.');
}


    public function edit($id_materi)
    {
        $materi = MateriTarbiyah::findOrFail($id_materi);
        $indikator = IndikatorTarbiyah::all();
        return view('materi_tarbiyah.form', compact('materi', 'indikator'));
    }

    public function update(Request $request, $id_materi)
{
    $request->validate([
        'materi' => 'required',
        'id_indikator' => 'required|exists:indikator_tarbiyah,id_indikator',
        'semester' => 'required',
        'status' => 'required|in:1,0',
    ]);

    $materi = MateriTarbiyah::findOrFail($id_materi);
    $materi->update([
        'materi' => $request->materi,
        'id_indikator' => $request->id_indikator,
        'semester' => $request->semester,
        'status' => $request->status,
    ]);

    return redirect()->route('materi_tarbiyah.index')->with('success', 'Data berhasil diupdate.');
}



    public function destroy($id_materi)
    {
        $materi = MateriTarbiyah::findOrFail($id_materi);
        $materi->delete();
        return redirect()->route('materi_tarbiyah.index')->with('success', 'Data berhasil dihapus.');
    }
}
