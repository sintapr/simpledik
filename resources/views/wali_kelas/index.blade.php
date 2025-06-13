@extends('layouts.app') 
@section('title', 'Data Wali Kelas')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <a href="{{ route('wali_kelas.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Wali Kelas</a>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@yield('title')</h4>

                    {{-- Form filter dan search --}}
                    <form method="GET" action="{{ route('wali_kelas.index') }}" class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label for="id_ta" class="form-label">Filter Tahun Ajaran</label>
                            <select name="id_ta" id="id_ta" class="form-control" onchange="this.form.submit()">
                                @foreach ($tahunAjaranList as $ta)
                                    <option value="{{ $ta->id_ta }}" {{ $id_ta == $ta->id_ta ? 'selected' : '' }}>
                                        {{ $ta->tahun_ajaran }} - {{ ucfirst($ta->semester) }}
                                        {{ $ta->status ? '(Aktif)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="search" class="form-label">Cari Nama Guru</label>
                            <input type="text" name="search" id="search" class="form-control"
                                value="{{ request('search') }}" placeholder="Cari nama guru...">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-primary w-100" type="submit">
                                <i class="fa fa-search"></i> Cari
                            </button>
                        </div>
                    </form>

                    {{-- Tabel data --}}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Wakel</th>
                                    <th>Nama Guru</th>
                                    <th>Kelas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($waliKelas as $wakel)
                                    <tr>
                                        <td>{{ $wakel->id_wakel }}</td>
                                        <td>{{ $wakel->guru->nama_guru ?? '-' }}</td>
                                        <td>{{ $wakel->kelas->nama_kelas ?? '-' }}</td>
                                        <td>{{ $wakel->tahunAjaran->tahun_ajaran }} - {{ $wakel->tahunAjaran->semester_text }}</td>
                                        <td>
                                            <a href="{{ route('wali_kelas.edit', $wakel->id_wakel) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('wali_kelas.destroy', $wakel->id_wakel) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center">Tidak ada data wali kelas</td></tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Keterangan jumlah data --}}
                        <p class="mt-2">
                            Menampilkan {{ $waliKelas->count() }} dari {{ $waliKelas->total() }} data wali kelas.
                        </p>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center">
                            {{ $waliKelas->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div> {{-- .table-responsive --}}
                </div> {{-- .card-body --}}
            </div> {{-- .card --}}
        </div>
    </div>
</div>
@endsection
