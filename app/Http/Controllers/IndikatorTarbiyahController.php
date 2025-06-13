<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndikatorTarbiyah;
use App\Models\Perkembangan;

class IndikatorTarbiyahController extends Controller
{
        public function index(Request $request)
    {
        $query = IndikatorTarbiyah::with('perkembangan');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('indikator', 'like', "%$search%")
                ->orWhere('semester', 'like', "%$search%")
                ->orWhereRaw("CASE WHEN status = 1 THEN 'Aktif' ELSE 'Tidak Aktif' END LIKE ?", ["%$search%"]);
        }

        $indikator = $query->paginate(10);

        return view('indikator.index', compact('indikator'));
    }


    public function create()
    {
        $indikator = new IndikatorTarbiyah();  // Untuk form tambah, buat objek kosong
        $perkembangan = Perkembangan::all();  // Ambil semua data perkembangan
        return view('indikator.form', compact('indikator', 'perkembangan'));
    }
    
    public function edit($id_indikator)
    {
        $indikator = IndikatorTarbiyah::findOrFail($id_indikator);  // Ambil data berdasarkan ID
        $perkembangan = Perkembangan::all();  // Ambil semua data perkembangan
        return view('indikator.form', compact('indikator', 'perkembangan'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'indikator' => 'required',
            'id_perkembangan' => 'required|exists:perkembangan,id_perkembangan',
            'semester' => 'required|in:1,2',
            'status' => 'required|in:1,0', // tambahkan validasi status
        ]);
    
        // Buat prefix berdasarkan semester
        $prefix = 'IT' . $request->semester . '-';
    
        // Cari ID terakhir yang sesuai dengan semester
        $last = IndikatorTarbiyah::where('id_indikator', 'like', $prefix . '%')
            ->orderBy('id_indikator', 'desc')
            ->first();
    
        if ($last) {
            $lastNumber = (int) substr($last->id_indikator, -3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
    
        // Format menjadi 3 digit (misal: 001, 002)
        $newId = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    
        // Simpan data
        IndikatorTarbiyah::create([
            'id_indikator' => $newId,
            'indikator' => $request->indikator,
            'id_perkembangan' => $request->id_perkembangan,
            'semester' => $request->semester,
            'status' => $request->status,
        ]);
    
        return redirect()->route('indikator.index')->with('success', 'Indikator berhasil ditambahkan');
    }
    
    
    
    public function update(Request $request, $id_indikator)
{
    $indikator = IndikatorTarbiyah::findOrFail($id_indikator);

    $request->validate([
        'indikator' => 'required',
        'id_perkembangan' => 'required|exists:perkembangan,id_perkembangan',
        'semester' => 'required|in:1,2',
        'status' => 'required|in:1,0',
    ]);

    $indikator->update([
        'indikator' => $request->indikator,
        'id_perkembangan' => $request->id_perkembangan,
        'semester' => $request->semester,
        'status' => $request->status,
    ]);

    return redirect()->route('indikator.index')->with('success', 'Data berhasil diupdate.');
}


    public function destroy($id_indikator)
{
    $indikator = IndikatorTarbiyah::findOrFail($id_indikator); // $id adalah id_indikator
    $indikator->delete();

    return redirect()->route('indikator.index')->with('success', 'Indikator berhasil dihapus');
}

}