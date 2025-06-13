<?php

namespace App\Http\Controllers;

use App\Models\SuratHafalan;
use App\Models\Perkembangan;
use Illuminate\Http\Request;

class SuratHafalanController extends Controller
{
    public function index(Request $request)
{
    $query = SuratHafalan::with('perkembangan');

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where('id_surat', 'like', "%$search%")
              ->orWhere('nama_surat', 'like', "%$search%")
              ->orWhereHas('perkembangan', function ($q) use ($search) {
                  $q->where('indikator', 'like', "%$search%");
              });
    }

    $suratHafalan = $query->orderBy('id_surat')->paginate(10);
    $perkembangan = Perkembangan::all();
    $newId = SuratHafalan::max('id_surat') ? 'H' . str_pad((int) filter_var(SuratHafalan::max('id_surat'), FILTER_SANITIZE_NUMBER_INT) + 1, 3, '0', STR_PAD_LEFT) : 'H001';

    return view('surat_hafalan.index', compact('suratHafalan', 'perkembangan', 'newId'));
}



    public function create()
    {
        // Generate ID otomatis: H001, H002, dst
        $last = SuratHafalan::orderBy('id_surat', 'desc')->first();
        $nextNumber = $last ? (int)substr($last->id_surat, 1) + 1 : 1;
        $newId = 'H' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $perkembangan = Perkembangan::all();
        return view('surat_hafalan.form', [
            'item' => new SuratHafalan(['id_surat' => $newId]),
            'perkembangan' => $perkembangan,
            'action' => route('surat-hafalan.store'),
            'method' => 'POST'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_surat' => 'required|unique:surat_hafalan',
            'nama_surat' => 'required|max:15',
            'id_perkembangan' => 'required'
        ]);

        SuratHafalan::create($request->all());
        return redirect()->route('surat-hafalan.index')->with('success', 'Surat Hafalan berhasil ditambahkan');
    }

    public function edit($id_surat)
    {
        $item = SuratHafalan::findOrFail($id_surat);
        $perkembangan = Perkembangan::all();

        return view('surat_hafalan.form', [
            'item' => $item,
            'perkembangan' => $perkembangan,
            'action' => route('surat-hafalan.update', $id_surat),
            'method' => 'PUT'
        ]);
    }

    public function update(Request $request, $id_surat)
    {
        $request->validate([
            'nama_surat' => 'required|max:15',
            'id_perkembangan' => 'required'
        ]);

        $item = SuratHafalan::findOrFail($id_surat);
        $item->update([
            'nama_surat' => $request->nama_surat,
            'id_perkembangan' => $request->id_perkembangan
        ]);

        return redirect()->route('surat-hafalan.index')->with('success', 'Surat Hafalan berhasil diperbarui');
    }

    public function destroy($id_surat)
    {
        SuratHafalan::findOrFail($id_surat)->delete();
        return redirect()->route('surat-hafalan.index')->with('success', 'Surat Hafalan berhasil dihapus');
    }
}
