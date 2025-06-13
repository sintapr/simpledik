@extends('layouts.app')

@section('title', 'Kirim Notifikasi Rapor')

@section('content')
<div class="container">
    <h3 class="mb-4 text-center">Kirim Notifikasi ke Orangtua</h3>

    <div class="card shadow">
        <div class="card-body">
            <p><strong>Nama Siswa:</strong> {{ $siswa->nama_siswa }}</p>
            <p><strong>NIS:</strong> {{ $siswa->NIS }}</p>
            <p><strong>Tahun Ajaran:</strong> {{ $tahunAjaran->tahun }} - Semester {{ $tahunAjaran->semester }}</p>

<form action="{{ route('laporan-semester.laporan.notify.form', [$siswa->NIS, $tahunAjaran->id_ta, $id_kelas]) }}" method="POST">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan Notifikasi</label>
                   <textarea name="pesan" id="pesan" rows="4" class="form-control" required>{{ 
"Assalamu’alaikum, Bapak/Ibu orangtua/wali dari {$siswa->nama_siswa}.
Rapor semester {$tahunAjaran->semester} Tahun Ajaran {$tahunAjaran->tahun} sudah tersedia dan dapat dilihat atau diunduh melalui sistem.
Terima kasih." }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Kirim Notifikasi</button>
<a href="{{ route('laporan-semester.rapor', [$id_kelas, $tahunAjaran->id_ta]) }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
