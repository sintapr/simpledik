@extends('layouts.app')

@section('title', 'Indikator Tarbiyah')

@section('content')
    <div class="row page-titles mx-0 align-items-center justify-content-between">
        <div class="col-auto">
            @if(auth('guru')->check() && auth('guru')->user()->jabatan === 'admin')
            <a href="{{ route('indikator.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Indikator
            </a>
            @endif
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
                        <thead class="text-center">
                            <tr>
                                <th>ID Indikator</th>
                                <th>Indikator</th>
                                <th>Indikator Perkembangan</th>
                                <th>Semester</th>
                                <th>Status</th>
                                @if(auth('guru')->check() && auth('guru')->user()->jabatan === 'admin')
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($indikator as $item)
                                <tr>
                                    <td class="text-center">{{ $item->id_indikator }}</td>
                                    <td>{{ $item->indikator }}</td>
                                    <td>{{ $item->perkembangan->indikator ?? '-' }}</td>
                                    <td class="text-center">{{ $item->semester }}</td>
                                   <td>
    <span class="badge {{ $item->status ? 'bg-success' : 'bg-danger' }} text-white">
        {{ $item->status ? 'Aktif' : 'Tidak Aktif' }}
    </span>
</td>

                                    @if(auth('guru')->check() && auth('guru')->user()->jabatan === 'admin')
                                    <td class="text-center">
                                        <a href="{{ route('indikator.edit', $item->id_indikator) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('indikator.destroy', $item->id_indikator) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth('guru')->check() && auth('guru')->user()->jabatan === 'admin' ? 6 : 5 }}" class="text-center text-muted">
                                        Tidak ada data ditemukan
                                    </td>
                                </tr>
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
