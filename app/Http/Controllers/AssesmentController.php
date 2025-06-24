<?php

namespace App\Http\Controllers;

use App\Models\Assesment;
use App\Models\Siswa;
use App\Models\TujuanPembelajaran;
use Illuminate\Http\Request;

class AssesmentController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $assesment = Assesment::with(['siswa', 'tujuan_pembelajaran'])
        ->when($search, function ($query) use ($search) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_siswa', 'like', '%' . $search . '%');
            })->orWhereHas('tujuan_pembelajaran', function ($q) use ($search) {
                $q->where('tujuan_pembelajaran', 'like', '%' . $search . '%');
            });
        })
        ->orderBy('tahun', 'desc')
        ->paginate(10);

    return view('assesment.index', compact('assesment'));
}
    public function create()
    {
        $siswa = Siswa::all();
        $tp = TujuanPembelajaran::all();
    
        // Ambil ID terakhir dari tabel
        $last = Assesment::orderBy('id_assesment', 'desc')->first();
        if ($last) {
            $lastNumber = intval(substr($last->id_assesment, 2));
            $newId = 'AS' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newId = 'AS001';
        }
    
        return view('assesment.form', compact('siswa', 'tp', 'newId'));
    }
    

    public function store(Request $request)
{
    $request->validate([
    'NIS' => 'required',
    'id_tp' => 'required',
    'tempat_waktu' => 'required',
    'kejadian_teramati' => 'required',
    'minggu' => 'required',
    'bulan' => 'required',
    'tahun' => 'required|integer',
    'semester' => 'required|in:1,2',
]);


    // Generate ID seperti di create
    $last = Assesment::orderBy('id_assesment', 'desc')->first();
    if ($last) {
        $lastNumber = intval(substr($last->id_assesment, 2));
        $newId = 'AS' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newId = 'AS001';
    }

    $data = $request->all();
    $data['id_assesment'] = $newId;

    Assesment::create($data);
    return redirect()->route('assesment.index')->with('success', 'Data berhasil ditambahkan.');
}


    public function edit($id_assesment)
    {
        $assesment = Assesment::findOrFail($id_assesment);
        $siswa = Siswa::all();
        $tp = TujuanPembelajaran::all();
        return view('assesment.form', compact('assesment', 'siswa', 'tp'));
    }

    public function update(Request $request, $id_assesment)
    {
        $request->validate([
    'NIS' => 'required',
    'id_tp' => 'required',
    'sudah_muncul' => 'required|in:0,1',
    'konteks' => 'required|string|max:255',
    'tempat_waktu' => 'required|string|max:255',
    'kejadian_teramati' => 'required|string',
    'minggu' => 'required|string|max:50',
    'bulan' => 'required|string|max:50',
    'tahun' => 'required|integer',
    'semester' => 'required|in:1,2',
]);



        $assesment = Assesment::findOrFail($id_assesment);
        $assesment->update($request->all());
        return redirect()->route('assesment.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id_assesment)
    {
        Assesment::destroy($id_assesment);
        return redirect()->route('assesment.index')->with('success', 'Data berhasil dihapus.');
    }
}
