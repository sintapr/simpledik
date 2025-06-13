@extends('layouts.app')

@section('title', 'Daftar Siswa Kelas ' . $wakel->kelas->nama_kelas)

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <h4 class="mb-0">@yield('title')</h4>
        <small>Tahun Ajaran: {{ $wakel->tahunAjaran->tahun }} - Semester: {{ $wakel->tahunAjaran->semester }}</small>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('laporan-assesment.index') }}">Daftar Kelas</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">@yield('title')</h4>

            {{-- Form Pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama siswa..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Siswa</th>
                            <th class="text-center">Sudah Muncul</th>
                            <th class="text-center">Minggu</th>
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $item)
                            @php
                                $data = $assesments[$item->NIS] ?? collect();
                                $first = $data->first();
                            @endphp
                            <tr>
                                <td>{{ $item->siswa->nama_siswa }}</td>
                                <td class="text-center">{{ $first && $first->sudah_muncul ? 'Ya' : 'Tidak' }}</td>
                                <td class="text-center">{{ $first->minggu ?? '-' }}</td>
                                <td class="text-center">{{ $first->tahun_mulai ?? '-' }}</td>
                                <td class="text-center">
                                    @if($first)
                                        <a href="{{ route('laporan-assesment.edit', [$item->NIS, $wakel->id_ta, $wakel->id_kelas, $first->minggu]) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-bell"></i> Notifikasi
                                        </a>
                                        <a href="{{ route('laporan-assesment.cetak', [$item->NIS, $wakel->id_kelas, $wakel->id_ta, $first->minggu]) }}" target="_blank" class="btn btn-sm btn-success">
                                            <i class="fa fa-file-pdf"></i> Cetak
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak Ada</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">Tidak ada siswa ditemukan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Jumlah data --}}
            <p class="mt-2">
                Menampilkan {{ $siswa->count() }} dari {{ $siswa->total() }} siswa
            </p>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $siswa->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>

            <a href="{{ route('laporan-assesment.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Kelas</a>
        </div>
    </div>
</div>
@endsection
