@extends('layouts.app')
@section('title', 'Kondisi Siswa')
@section('content')
    <div class="row page-titles mx-0 align-items-center justify-content-between">
        <div class="col-auto">
            <a href="{{ route('kondisi-siswa.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Kondisi</a>
        </div>
        <div class="col-auto">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('kondisi-siswa.index') }}">@yield('title')</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data @yield('title')</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Kondisi</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>BB</th>
                                <th>TB</th>
                                <th>LK</th>
                                <th>Penglihatan</th>
                                <th>Pendengaran</th>
                                <th>Gigi</th>
                                <th>TA</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kondisi as $k)
                                <tr>
                                    <td>{{ $k->id_kondisi }}</td>
                                    <td>{{ $k->NIS }}</td>
                                    <td>{{ $k->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $k->BB }}</td>
                                    <td>{{ $k->TB }}</td>
                                    <td>{{ $k->LK }}</td>
                                    <td>{{ $k->penglihatan }}</td>
                                    <td>{{ $k->pendengaran }}</td>
                                    <td>{{ $k->gigi }}</td>
                                    <td>{{ $k->tahunAjaran->tahun_mulai ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('kondisi-siswa.edit', $k->id_kondisi) }}"
                                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('kondisi-siswa.destroy', $k->id_kondisi) }}"
                                            method="POST" class="d-inline form-delete">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
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
