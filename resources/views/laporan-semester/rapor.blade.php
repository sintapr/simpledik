@extends('layouts.app')

@section('title', 'Daftar Rapor Siswa')

@section('content')
<div class="container">
    <h3 class="mb-4 text-center">Daftar Rapor Siswa</h3>

    <p>
        <strong>Kelas:</strong> {{ $kelas->nama_kelas }} <br>
        <strong>Tahun Ajaran:</strong> {{ $ta->semester }} - {{ $ta->tahun_mulai }}
    </p>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID Rapor</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Tahun Ajaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $d)
                <tr>
                    <td>{{ $d->id_rapor }}</td>
                    <td>{{ $d->NIS }}</td>
                    <td>{{ $d->siswa->nama_siswa ?? 'Tidak ditemukan' }}</td>
                    <td>{{ $kelas->nama_kelas }}</td>
                    <td>{{ $ta->tahun_mulai }}</td>
                    <td>
                        <a href="{{ route('laporan-semester.laporan.show', [$d->siswa->NIS, $ta->id_ta, $ta->semester]) }}" class="btn btn-sm btn-primary">
                            Lihat
                        </a>
                        <a href="{{ route('laporan-semester.laporan.edit', [$d->siswa->NIS, $ta->id_ta]) }}" class="btn btn-sm btn-warning">
                            Edit / Notifikasi
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data rapor untuk kelas ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
