<?php

namespace App\Http\Controllers;

use App\Models\DetailNilaiTarbiyah;
use App\Models\MateriTarbiyah;
use App\Models\MonitoringSemester;
use Illuminate\Http\Request;

class DetailNilaiTarbiyahController extends Controller
{
    public function index(Request $request)
{
    $query = DetailNilaiTarbiyah::with(['rapor', 'materi']);

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->whereHas('rapor', function ($q) use ($search) {
            $q->where('id_rapor', 'like', "%$search%");
        })->orWhereHas('materi', function ($q) use ($search) {
            $q->where('materi', 'like', "%$search%");
        });
    }

    $data = $query->orderBy('id_detail_nilai_tarbiyah')->paginate(10);
    return view('detail_nilai_tarbiyah.index', compact('data'));
}


        public function create()
    {
        // Ambil ID terakhir
        $last = DetailNilaiTarbiyah::orderBy('id_detail_nilai_tarbiyah', 'desc')->first();
        $nextNumber = $last ? (int)substr($last->id_detail_nilai_tarbiyah, 3) + 1 : 1;

        // Format jadi DPT001, DPT002, dst.
        $newId = 'DPT' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('detail_nilai_tarbiyah.form', [
            'item' => new DetailNilaiTarbiyah(['id_detail_nilai_tarbiyah' => $newId]),
            'rapor' => MonitoringSemester::all(),
            'materi' => MateriTarbiyah::all(),
            'nilai_options' => ['Mumtaz', 'Jayyid Jiddan', 'Jayyid', 'Maqbul'],
            'action' => route('detail_nilai_tarbiyah.store'),
            'method' => 'POST'
        ]);
    }


        public function store(Request $request)
    {
        $request->validate([
            'id_detail_nilai_tarbiyah' => 'required|unique:detail_nilai_tarbiyah',
            'id_rapor' => 'required',
            'id_materi' => 'required',
            'nilai' => 'required|in:Mumtaz,Jayyid Jiddan,Jayyid,Maqbul'
        ]);

        DetailNilaiTarbiyah::create($request->all());
        return redirect()->route('detail_nilai_tarbiyah.index')->with('success', 'Data berhasil ditambahkan');
    }


    public function edit($id_detail_nilai_tarbiyah)
    {
        $item = DetailNilaiTarbiyah::findOrFail($id_detail_nilai_tarbiyah);
        return view('detail_nilai_tarbiyah.form', [
            'item' => $item,
            'rapor' => MonitoringSemester::all(),
            'materi' => MateriTarbiyah::all(),
            'nilai_options' => ['Mumtaz', 'Jayyid Jiddan', 'Jayyid', 'Maqbul'],
            'action' => route('detail_nilai_tarbiyah.update', $id_detail_nilai_tarbiyah),
            'method' => 'PUT'
        ]);
    }

        public function update(Request $request, $id_detail_nilai_tarbiyah)
    {
        $item = DetailNilaiTarbiyah::findOrFail($id_detail_nilai_tarbiyah);

        $request->validate([
            'id_rapor' => 'required',
            'id_materi' => 'required',
            'nilai' => 'required|in:Mumtaz,Jayyid Jiddan,Jayyid,Maqbul'
        ]);

        $item->update([
            'id_rapor' => $request->id_rapor,
            'id_materi' => $request->id_materi,
            'nilai' => $request->nilai
        ]);

        return redirect()->route('detail_nilai_tarbiyah.index')->with('success', 'Data berhasil diperbarui');
    }


    public function destroy($id_detail_nilai_tarbiyah)
    {
        DetailNilaiTarbiyah::destroy($id_detail_nilai_tarbiyah);
        return redirect()->route('detail_nilai_tarbiyah.index')->with('success', 'Data berhasil dihapus');
    }
}
