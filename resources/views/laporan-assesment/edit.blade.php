@extends('layouts.app')

@section('title', 'Kirim Notifikasi Laporan Mingguan')

@section('content')
<div class="container">
    <h3 class="mb-4 text-center">Kirim Notifikasi Laporan Mingguan ke Orangtua</h3>

    <div class="card shadow">
        <div class="card-body">
            <p><strong>Nama Siswa:</strong> {{ $siswa->nama_siswa }}</p>
            <p><strong>NIS:</strong> {{ $siswa->NIS }}</p>
            <p><strong>Tahun Ajaran:</strong> {{ $tahunAjaran->tahun_mulai }}/{{ $tahunAjaran->tahun_selesai }} - Semester {{ $tahunAjaran->semester }}</p>
            <p><strong>Minggu ke:</strong> {{ $minggu }}</p>

            <form action="{{ route('laporan-assesment.laporan.notify', [$siswa->NIS, $tahunAjaran->id_ta, $kelas->id_kelas, $minggu]) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan Notifikasi</label>
                    <textarea name="pesan" id="pesan" rows="4" class="form-control" required>{{
"Assalamu’alaikum, Bapak/Ibu orangtua/wali dari {$siswa->nama_siswa}.
Laporan perkembangan siswa untuk Minggu ke-{$minggu}, Semester {$tahunAjaran->semester} Tahun Ajaran {$tahunAjaran->tahun_mulai}/{$tahunAjaran->tahun_selesai} sudah tersedia di sistem.
Silakan login untuk melihat detail laporan.
Terima kasih."
                    }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Kirim Notifikasi</button>
                <a href="{{ route('laporan-assesment.showByKelas', [$kelas->id_kelas, $tahunAjaran->id_ta, $minggu]) }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
