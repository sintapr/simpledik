@extends('layouts.app') 

@section('title', 'Daftar Rapor Siswa')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <h4 class="mb-0">@yield('title')</h4>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">@yield('title')</h4>

            <p class="mb-3">
                <strong>Kelas:</strong> {{ $kelas->nama_kelas }}<br>
                <strong>Tahun Ajaran:</strong> Semester {{ $ta->semester }} - {{ $ta->tahun_mulai }}
            </p>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-center">
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
                            <td class="text-center">{{ $d->id_rapor }}</td>
                            <td class="text-center">{{ $d->NIS }}</td>
                            <td>{{ $d->siswa->nama_siswa ?? 'Tidak ditemukan' }}</td>
                            <td class="text-center">{{ $kelas->nama_kelas }}</td>
                            <td class="text-center">{{ $ta->tahun_mulai }}</td>
                            <td class="text-center">
                                <a href="{{ route('laporan-semester.laporan.show', [$d->siswa->NIS, $ta->id_ta, $ta->semester]) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i> Lihat
                                </a>
                                <a href="{{ route('laporan-semester.laporan.edit', [$d->siswa->NIS, $ta->id_ta]) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i> Edit / Notifikasi
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

            <p class="mt-2">
                Menampilkan {{ count($data) }} data
            </p>
        </div>
    </div>
</div>
@endsection
