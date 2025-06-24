<?php

namespace App\Http\Controllers;

use App\Models\Fase;
use Illuminate\Http\Request;

class FaseController extends Controller
{
    public function index(Request $request)
{
    $query = Fase::query();

    if ($request->filled('search')) {
        $query->where('id_fase', 'like', '%' . $request->search . '%')
              ->orWhere('nama_fase', 'like', '%' . $request->search . '%');
    }

    $fase = $query->paginate(10)->appends($request->query());

    return view('fase.index', compact('fase'));
}



    public function create()
    {
            $lastFase = Fase::orderBy('id_fase', 'desc')->first();
        
            if ($lastFase) {
                $lastNumber = (int) substr($lastFase->id_fase, 2); // Ambil angka setelah "F"
                $newId = 'F' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newId = 'F001';
            }
        
            $fase = new Fase();
            $fase->id_fase = $newId;
        
        
        return view('fase.form', ['fase' => new Fase()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_fase' => 'required|string|max:8|unique:fase,id_fase',
            'nama_fase' => 'required|string|max:13',
        ]);

        Fase::create($request->all());

        return redirect()->route('fase.index')->with('success', 'Fase berhasil ditambahkan.');
    }

    public function edit($id_fase)
    {
        $fase = Fase::findOrFail($id_fase);
        return view('fase.form', compact('fase'));
    }

    public function update(Request $request, $id_fase)
    {
        $request->validate([
            'nama_fase' => 'required|string|max:13',
        ]);

        $fase = Fase::findOrFail($id_fase);
        $fase->update($request->only('nama_fase'));

        return redirect()->route('fase.index')->with('success', 'Fase berhasil diperbarui.');
    }

    public function destroy($id_fase)
    {
        $fase = Fase::findOrFail($id_fase);
        $fase->delete();

        return redirect()->route('fase.index')->with('success', 'Fase berhasil dihapus.');
    }
}
