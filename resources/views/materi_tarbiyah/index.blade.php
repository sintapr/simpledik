@extends('layouts.app')

@section('title', 'Materi Tarbiyah')

@section('content')
    <div class="row page-titles mx-0 align-items-center justify-content-between">
        <div class="col-auto">
            <a href="{{ route('materi_tarbiyah.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Materi
            </a>
        </div>
        <div class="col-auto">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('materi_tarbiyah.index') }}">@yield('title')</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data @yield('title')</h4>

                {{-- Form Pencarian --}}
                <form method="GET" class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Cari materi atau semester..."
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
                                <th>ID Materi</th>
                                <th>Materi</th>
                                <th>Indikator</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($materi as $m)
                                <tr>
                                    <td>{{ $m->id_materi }}</td>
                                    <td>{{ $m->materi }}</td>
                                    <td>{{ $m->indikator->indikator ?? '-' }}</td>
                                    <td>{{ $m->semester }}</td>
                                    <td>
                                        <span class="badge {{ $m->status ? 'bg-success' : 'bg-secondary' }} text-white">
                                            {{ $m->status ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('materi_tarbiyah.edit', $m->id_materi) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('materi_tarbiyah.destroy', $m->id_materi) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">Tidak ada data materi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Jumlah data --}}
                <p class="mt-2">
                    Menampilkan {{ $materi->count() }} dari {{ $materi->total() }} data Materi Tarbiyah
                </p>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $materi->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
