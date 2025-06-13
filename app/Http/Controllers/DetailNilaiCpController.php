<?php

namespace App\Http\Controllers;

use App\Models\DetailNilaiCp;
use App\Models\MonitoringSemester;
use App\Models\PenilaianCp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailNilaiCpController extends Controller
{
    public function index(Request $request)
{
    $query = DetailNilaiCP::with(['rapor', 'penilaian']);

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;

        $query->whereHas('rapor', function ($q) use ($search) {
            $q->where('id_rapor', 'like', "%$search%");
        })->orWhereHas('penilaian', function ($q) use ($search) {
            $q->where('aspek_nilai', 'like', "%$search%");
        });
    }

    $data = $query->orderBy('id_detail_nilai_cp')->paginate(10);
    return view('detail_nilai_cp.index', compact('data'));
}


    public function create()
    {
        $lastId = DetailNilaiCp::max('id_detail_nilai_cp');
        $newId = 'DCP001';

        if ($lastId) {
            $number = (int) substr($lastId, 3);
            $newId = 'DCP' . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('detail_nilai_cp.form', [
            'item' => new DetailNilaiCp(['id_detail_nilai_cp' => $newId]),
            'rapor' => MonitoringSemester::all(),
            'penilaian' => PenilaianCp::all(),
            'action' => route('detail_nilai_cp.store'),
            'method' => 'POST'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_detail_nilai_cp' => 'required|unique:detail_nilai_cp',
            'id_rapor' => 'required',
            'id_penilaian_cp' => 'required',
            'nilai' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only(['id_detail_nilai_cp', 'id_rapor', 'id_penilaian_cp', 'nilai']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_cp', 'public');
        } else {
            $data['foto'] = ''; // Default kosong jika tidak upload
        }

        DetailNilaiCp::create($data);

        return redirect()->route('detail_nilai_cp.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id_detail_nilai_cp)
    {
        $item = DetailNilaiCp::findOrFail($id_detail_nilai_cp);
        return view('detail_nilai_cp.form', [
            'item' => $item,
            'rapor' => MonitoringSemester::all(),
            'penilaian' => PenilaianCp::all(),
            'action' => route('detail_nilai_cp.update', $id_detail_nilai_cp),
            'method' => 'PUT'
        ]);
    }

    public function update(Request $request, $id_detail_nilai_cp)
    {
        $request->validate([
            'id_rapor' => 'required',
            'id_penilaian_cp' => 'required',
            'nilai' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $item = DetailNilaiCp::findOrFail($id_detail_nilai_cp);
        $data = $request->only(['id_rapor', 'id_penilaian_cp', 'nilai']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($item->foto && Storage::disk('public')->exists($item->foto)) {
                Storage::disk('public')->delete($item->foto);
            }

            // Upload foto baru
            $data['foto'] = $request->file('foto')->store('foto_cp', 'public');
        }

        $item->update($data);

        return redirect()->route('detail_nilai_cp.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id_detail_nilai_cp)
    {
        $item = DetailNilaiCp::findOrFail($id_detail_nilai_cp);

        // Hapus file foto jika ada
        if ($item->foto && Storage::disk('public')->exists($item->foto)) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return redirect()->route('detail_nilai_cp.index')->with('success', 'Data berhasil dihapus');
    }
}
