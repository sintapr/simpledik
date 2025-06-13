<?php

namespace App\Http\Controllers;

use App\Models\MonitoringSemester;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Fase;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class MonitoringSemesterController extends Controller
{
        public function index(Request $request)
    {
        $query = MonitoringSemester::with(['siswa', 'kelas', 'guru', 'fase', 'tahunAjaran']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('NIS', 'like', "%$search%")
                ->orWhereHas('siswa', fn($q) => $q->where('nama', 'like', "%$search%"))
                ->orWhereHas('kelas', fn($q) => $q->where('nama_kelas', 'like', "%$search%"))
                ->orWhereHas('guru', fn($q) => $q->where('nama_guru', 'like', "%$search%"));
            });
        }

        $monitoring = $query->paginate(10);
        return view('monitoring.index', compact('monitoring'));
    }


    public function create()
    {
        $tahun = TahunAjaran::all();
    
        $defaultSemester = $tahun->first()?->semester ?? 1; // default jika belum ada data
        $prefix = 'R' . $defaultSemester . '-';
    
        $last = MonitoringSemester::where('id_rapor', 'like', $prefix . '%')->orderBy('id_rapor', 'desc')->first();
        $lastNumber = $last ? (int) substr($last->id_rapor, 3) : 0;
        $newId = $prefix . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    
        return view('monitoring.form', [
            'monitoring' => new MonitoringSemester(['id_rapor' => $newId]),
            'siswa' => Siswa::all(),
            'kelas' => Kelas::all(),
            'guru' => Guru::all(),
            'fase' => Fase::all(),
            'tahun' => $tahun,
            'action' => route('monitoring.store'),
            'method' => 'POST',
        ]);
    }
    


        public function store(Request $request)
    {
        $request->validate([
            'NIS' => 'required',
            'id_kelas' => 'required',
            'NIP' => 'required',
            'id_fase' => 'required',
            'id_ta' => 'required|exists:tahun_ajaran,id_ta',
        ]);

        $semester = TahunAjaran::findOrFail($request->id_ta)->semester;
        $prefix = 'R' . $semester . '-';
        $nis = $request->NIS;

        // Cek apakah semester 2 dan siswa sudah punya rapor semester 1
        if ($semester == 2) {
            $raporSemester1 = MonitoringSemester::where('NIS', $nis)
                ->whereHas('tahunAjaran', function ($q) {
                    $q->where('semester', 1);
                })
                ->first();

            if ($raporSemester1) {
                // Ambil nomor rapor dari semester 1 dan gunakan untuk semester 2
                $number = substr($raporSemester1->id_rapor, 3); // misal dari R1-001 ambil "001"
                $newId = $prefix . $number;
            } else {
                // Jika tidak ada rapor semester 1, buat nomor baru
                $last = MonitoringSemester::where('id_rapor', 'like', $prefix . '%')->orderByDesc('id_rapor')->first();
                $lastNumber = $last ? (int) substr($last->id_rapor, 3) : 0;
                $newId = $prefix . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            }
        } else {
            // Semester 1 → generate nomor baru
            $last = MonitoringSemester::where('id_rapor', 'like', $prefix . '%')->orderByDesc('id_rapor')->first();
            $lastNumber = $last ? (int) substr($last->id_rapor, 3) : 0;
            $newId = $prefix . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        $request->merge(['id_rapor' => $newId]);

        MonitoringSemester::create($request->all());

        return redirect()->route('monitoring.index')->with('success', 'Data berhasil disimpan');
    }

        public function generateIdRapor(Request $request)
    {
        $semester = $request->semester;
        $nis = $request->nis;

        if (!$semester || !$nis) {
            return response()->json(['error' => 'Semester dan NIS harus diisi'], 400);
        }

        $prefix = 'R' . $semester . '-';

        // Cek apakah semester 1 sudah ada
        $existingRaporSmt1 = MonitoringSemester::where('NIS', $nis)
            ->whereHas('tahunAjaran', function ($q) {
                $q->where('semester', 1);
            })->first();

        if ($semester == 2 && $existingRaporSmt1) {
            // Gunakan nomor yang sama dari R1-xxx
            $lastNumber = (int) substr($existingRaporSmt1->id_rapor, 3);
            $newId = $prefix . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
        } else {
            // Buat baru
            $last = MonitoringSemester::where('id_rapor', 'like', $prefix . '%')->orderBy('id_rapor', 'desc')->first();
            $lastNumber = $last ? (int) substr($last->id_rapor, 3) : 0;
            $newId = $prefix . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        return response()->json(['id_rapor' => $newId]);
    }


    
    public function edit($id_rapor)
    {
        $monitoring = MonitoringSemester::findOrFail($id_rapor);
        return view('monitoring.form', [
            'monitoring' => $monitoring,
            'siswa' => Siswa::all(),
            'kelas' => Kelas::all(),
            'guru' => Guru::all(),
            'fase' => Fase::all(),
            'tahun' => TahunAjaran::all(),
            'action' => route('monitoring.update', $monitoring->id_rapor),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, $id_rapor)
    {
        $monitoring = MonitoringSemester::findOrFail($id_rapor);
        $monitoring->update($request->all());
        return redirect()->route('monitoring.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id_rapor)
    {
        $monitoring = MonitoringSemester::findOrFail($id_rapor);
        $monitoring->delete();
        return redirect()->route('monitoring.index')->with('success', 'Data berhasil dihapus');
    }
}
