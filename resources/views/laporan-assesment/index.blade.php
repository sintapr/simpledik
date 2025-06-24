@extends('layouts.app')
@section('title', 'Data Tahun Ajaran')
@section('content')

<div class="row page-titles mx-0 justify-content-between align-items-center">
    <div class="col-auto">
        <h4 class="mb-0">@yield('title')</h4>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            {{-- <li class="breadcrumb-item active">@yield('title')</li> --}}
            <li class="breadcrumb-item active"><a href="{{ route('laporan-assesment.index') }}">@yield('title')</a></li>

        </ol>
    </div>
</div>

<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">@yield('title')</h4>

           {{-- Form pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari kelas atau Tahun Ajaran..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <!-- Tombol Cari -->
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($waliKelasList as $wakel)
                            <tr>
                                <td>{{ $wakel->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $wakel->tahunAjaran->tahun_mulai ?? '-' }}</td>
                                <td>{{ $wakel->tahunAjaran->semester ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('laporan-assesment.showByKelas', [$wakel->id_kelas, $wakel->id_ta]) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
