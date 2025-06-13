@extends('layouts.app')

@section('title', 'Indikator Tarbiyah')

@section('content')
    <div class="row page-titles mx-0 align-items-center justify-content-between">
        <div class="col-auto">
            <a href="{{ route('indikator.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Indikator</a>
        </div>
        <div class="col-auto">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('indikator.index') }}">@yield('title')</a></li>
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
                        <input type="text" name="search" class="form-control" placeholder="Cari indikator, semester, atau status..."
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
                                <th>ID Indikator</th>
                                <th>Indikator</th>
                                <th>Indikator Perkembangan</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($indikator as $item)
                                <tr>
                                    <td>{{ $item->id_indikator }}</td>
                                    <td>{{ $item->indikator }}</td>
                                    <td>{{ $item->perkembangan->indikator ?? '-' }}</td>
                                    <td>{{ $item->semester }}</td>
                                    <td>
                                        <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }} text-white">
                                            {{ $item->status ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('indikator.edit', $item->id_indikator) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('indikator.destroy', $item->id_indikator) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">Tidak ada data ditemukan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <p class="mt-2">
                    Menampilkan {{ $indikator->count() }} dari total {{ $indikator->total() }} data
                </p>

                <div class="d-flex justify-content-center">
                    {{ $indikator->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
