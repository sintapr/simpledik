@extends('layouts.app') 
@section('title', 'Detail Rapor')
@section('content')

<div class="row page-titles mx-0 justify-content-between align-items-center">
    <div class="col-auto">
        <a href="{{ route('detail_rapor.create') }}" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Tambah @yield('title')
        </a>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
        </ol>
    </div>
</div>

<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">@yield('title')</h4>

            {{-- Form Pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari ID Rapor atau Indikator..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit"><i class="fa fa-search"></i> Cari</button>
                </div>
            </form>

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Detail</th>
                            <th>ID Rapor</th>
                            <th>Indikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($detail_rapor as $item)
                            <tr>
                                <td>{{ $item->no_detail_rapor }}</td>
                                <td>{{ $item->rapor->id_rapor ?? $item->id_rapor }}</td>
                                <td>{{ $item->perkembangan->indikator ?? $item->id_perkembangan }}</td>
                                <td>
                                    <a href="{{ route('detail_rapor.edit', $item->no_detail_rapor) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('detail_rapor.destroy', $item->no_detail_rapor) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Info dan Pagination --}}
            <p class="mt-2">Menampilkan {{ $detail_rapor->count() }} dari {{ $detail_rapor->total() }} data</p>
            <div class="d-flex justify-content-center">
                {{ $detail_rapor->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@endsection
