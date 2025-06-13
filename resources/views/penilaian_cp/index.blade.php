@extends('layouts.app')
@section('title', 'Data Penilaian CP')

@section('content')
<div class="row page-titles mx-0 justify-content-between align-items-center">
    <div class="col-auto">
        <a href="{{ route('penilaian_cp.create') }}" class="btn btn-primary mb-3">
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

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">@yield('title')</h4>

            {{-- Form Pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari indikator atau aspek nilai..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </form>

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Penilaian</th>
                            <th>Indikator</th>
                            <th>Aspek Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penilaian as $item)
                        <tr>
                            <td>{{ $item->id_penilaian_cp }}</td>
                            <td>{{ $item->perkembangan->indikator ?? '-' }}</td>
                            <td>{{ $item->aspek_nilai }}</td>
                            <td>
                                <a href="{{ route('penilaian_cp.edit', $item->id_penilaian_cp) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('penilaian_cp.destroy', $item->id_penilaian_cp) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Data tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Keterangan jumlah --}}
            <p class="mt-2">Menampilkan {{ $penilaian->count() }} dari {{ $penilaian->total() }} data penilaian</p>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $penilaian->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
