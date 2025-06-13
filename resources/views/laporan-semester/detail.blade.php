@extends('layouts.app')

@section('title', 'Detail Data Rapor')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <a href="{{ route('laporan-semester.index') }}" class="btn btn-secondary mb-3">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('laporan-semester.index') }}">Laporan Semester</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">📋 @yield('title')</h4>

            {{-- Search bar tambahan (walau data tunggal, untuk konsistensi UI) --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari tahun ajaran, kelas atau wali kelas..."
                        value="{{ request('search') }}" disabled>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-secondary" type="submit" disabled>
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </form>

            {{-- Table data detail --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tahun Ajaran</th>
                            <th>Kelas</th>
                            <th>Wali Kelas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($waliKelasList as $waliKelas)
                        <tr>
                            <td>{{ $waliKelas->tahunAjaran->tahun_mulai }} - Semester {{ $waliKelas->tahunAjaran->semester }}</td>
                            <td>{{ $waliKelas->kelas->nama_kelas }}</td>
                            <td>{{ $waliKelas->guru->nama_guru }}</td>
                            <td>
                                @if ($waliKelas->tahunAjaran->status == 1)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('laporan-semester.rapor', ['id_kelas' => $waliKelas->id_kelas, 'id_ta' => $waliKelas->id_ta]) }}"
                                    class="btn btn-sm btn-primary">
                                    Melihat
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
