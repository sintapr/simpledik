@extends('layouts.app')
@section('title', 'Laporan Assesment - Wali Kelas')
@section('content')

<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <h4 class="mb-0">@yield('title')</h4>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">@yield('title')</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
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
            <td>{{ $wakel->kelas->nama_kelas ?? 'Tidak ada kelas' }}</td>
            <td>{{ $wakel->tahunAjaran->tahun_mulai ?? 'Tidak ada tahun ajaran' }}</td>
            <td>{{ $wakel->tahunAjaran->semester ?? 'Tidak ada semester' }}</td>
            <td>
                <a href="{{ route('laporan-assesment.showByKelas', [$wakel->kelas->id_kelas, $wakel->id_ta]) }}"
                   class="btn btn-primary btn-sm">Lihat</a>
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
