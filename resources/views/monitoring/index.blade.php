@extends('layouts.app')

@section('title', 'Data Monitoring Semester')

@section('content')
    <div class="row page-titles mx-0 align-items-center justify-content-between">
        <div class="col-auto">
            <a href="{{ route('monitoring.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Monitoring</a>
        </div>
        <div class="col-auto">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('monitoring.index') }}">@yield('title')</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data @yield('title')</h4>

                {{-- Form Pencarian --}}
                <form method="GET" class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Cari NIS, kelas, atau guru..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">
                            <i class="fa fa-search"></i> Cari
                    </button>                                        
                </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Rapor</th>
                                <th>NIS</th>
                                <th>Kelas</th>
                                <th>Guru</th>
                                <th>Fase</th>
                                <th>Tahun Ajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monitoring as $item)
                                <tr>
                                    <td>{{ $item->id_rapor }}</td>
                                    <td>{{ $item->siswa->nama ?? $item->NIS }}</td>
                                    <td>{{ $item->kelas->nama_kelas ?? $item->id_kelas }}</td>
                                    <td>{{ $item->guru->nama_guru ?? $item->NIP }}</td>
                                    <td>{{ $item->fase->nama_fase ?? $item->id_fase }}</td>
                                    <td>{{ $item->tahunAjaran->tahun_ajaran }} - {{ $item->tahunAjaran->semester_text }}</td>
                                    <td>
                                        <a href="{{ route('monitoring.edit', $item->id_rapor) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('monitoring.destroy', $item->id_rapor) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin hapus?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center">Tidak ada data ditemukan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <p class="mt-2">
                    Menampilkan {{ $monitoring->count() }} dari total {{ $monitoring->total() }} data
                </p>

                <div class="d-flex justify-content-center">
                    {{ $monitoring->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
