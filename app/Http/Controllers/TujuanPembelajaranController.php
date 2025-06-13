<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TujuanPembelajaran;

class TujuanPembelajaranController extends Controller
{
    public function index(Request $request)
    {
        $tujuan = TujuanPembelajaran::all();
        $search = $request->input('search');

        $tujuan = TujuanPembelajaran::when($search, function ($query) use ($search) {
            $query->where('tujuan_pembelajaran', 'like', '%' . $search . '%')
                            ->orWhere('id_tp', 'like', "%{$search}%");

        })
        ->orderBy('id_tp', 'asc')
        ->paginate(10);

        // Generate ID baru
        $last = TujuanPembelajaran::orderByDesc('id_tp')->first();
        $lastNumber = $last ? (int) substr($last->id_tp, 2) : 0;
        $newId = 'TP' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        $newStatus = 1; // Default status aktif

        return view('tujuan_pembelajaran.index', compact('tujuan', 'newId', 'newStatus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tujuan_pembelajaran' => 'required',
            'status' => 'required|in:0,1',
        ]);

        // Generate ID otomatis
        $last = TujuanPembelajaran::orderBy('id_tp', 'desc')->first();
        $newId = 'TP001';

        if ($last) {
            $number = (int) substr($last->id_tp, 2);
            $newNumber = str_pad($number + 1, 3, '0', STR_PAD_LEFT);
            $newId = 'TP' . $newNumber;
        }

        TujuanPembelajaran::create([
            'id_tp' => $newId,
            'tujuan_pembelajaran' => $request->tujuan_pembelajaran,
            'status' => $request->status,
        ]);

        return redirect()->route('tujuan.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id_tp)
    {
        $request->validate([
            'tujuan_pembelajaran' => 'required',
            'status' => 'required|in:0,1',
        ]);

        $data = TujuanPembelajaran::findOrFail($id_tp);
        $data->update([
            'tujuan_pembelajaran' => $request->tujuan_pembelajaran,
            'status' => $request->status,
        ]);

        return redirect()->route('tujuan.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id_tp)
    {
        TujuanPembelajaran::destroy($id_tp);
        return redirect()->route('tujuan.index')->with('success', 'Data berhasil dihapus');
    }
}
