<?php

namespace App\Http\Controllers;

use App\Models\DetailNilaiP5;
use App\Models\MonitoringSemester;
use App\Models\Perkembangan;
use Illuminate\Http\Request;

class DetailNilaiP5Controller extends Controller
{
    public function index(Request $request)
{
    $query = DetailNilaiP5::with(['rapor', 'perkembangan']);

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;

        $query->whereHas('rapor', function ($q) use ($search) {
            $q->where('id_rapor', 'like', "%$search%");
        })->orWhereHas('perkembangan', function ($q) use ($search) {
            $q->where('indikator', 'like', "%$search%");
        });
    }

    $data = $query->orderBy('id_detail_nilai_p5')->paginate(10);
    return view('detail_nilai_p5.index', compact('data'));
}


    public function create()
    {
        $last = DetailNilaiP5::orderBy('id_detail_nilai_p5', 'desc')->first();
        $nextNumber = $last ? (int)substr($last->id_detail_nilai_p5, 3) + 1 : 1;
        $newId = 'DNP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('detail_nilai_p5.form', [
            'item' => new DetailNilaiP5(['id_detail_nilai_p5' => $newId]),
            'rapor' => MonitoringSemester::all(),
            'perkembangan' => Perkembangan::all(),
            'action' => route('detail_nilai_p5.store'),
            'method' => 'POST'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_detail_nilai_p5' => 'required|unique:detail_nilai_p5',
            'id_rapor' => 'required',
            'id_perkembangan' => 'required',
            'nilai' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('public/foto_nilai_p5', $foto);
        }

        DetailNilaiP5::create([
            'id_detail_nilai_p5' => $request->id_detail_nilai_p5,
            'id_rapor' => $request->id_rapor,
            'id_perkembangan' => $request->id_perkembangan,
            'nilai' => $request->nilai,
            'foto' => $foto ?? ''
        ]);

        return redirect()->route('detail_nilai_p5.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id_detail_nilai_p5)
    {
        $item = DetailNilaiP5::findOrFail($id_detail_nilai_p5);
        return view('detail_nilai_p5.form', [
            'item' => $item,
            'rapor' => MonitoringSemester::all(),
            'perkembangan' => Perkembangan::all(),
            'action' => route('detail_nilai_p5.update', $id_detail_nilai_p5),
            'method' => 'PUT'
        ]);
    }

    public function update(Request $request, $id_detail_nilai_p5)
    {
        $request->validate([
            'id_rapor' => 'required',
            'id_perkembangan' => 'required',
            'nilai' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $item = DetailNilaiP5::findOrFail($id_detail_nilai_p5);

        // Simpan foto baru jika ada
        if ($request->hasFile('foto')) {
            $fotoBaru = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('public/foto_nilai_p5', $fotoBaru);
            $item->foto = $fotoBaru;
        }

        $item->update([
            'id_rapor' => $request->id_rapor,
            'id_perkembangan' => $request->id_perkembangan,
            'nilai' => $request->nilai,
            'foto' => $item->foto
        ]);

        return redirect()->route('detail_nilai_p5.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id_detail_nilai_p5)
    {
        DetailNilaiP5::destroy($id_detail_nilai_p5);
        return redirect()->route('detail_nilai_p5.index')->with('success', 'Data berhasil dihapus');
    }
}
