@extends('layouts.app')

@section('title', 'Tahun Ajaran')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahTA">
            <i class="fa fa-plus"></i> Tambah @yield('title')
        </button>
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
            <h4>@yield('title')</h4>

            {{-- Form pencarian --}}
            <form method="GET" class="row mb-3" action="{{ route('tahun-ajaran.index') }}">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari semester atau tahun..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>                
                </div>
            </form>

            {{-- Tabel --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Semester</th>
                        <th>Tahun Ajaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tahunAjaran as $item)
                    <tr>
                        <td>{{ $item->id_ta }}</td>
                        <td>{{ $item->semester }}</td>
                        <td>{{ $item->tahun_ajaran }}</td>
                        <td>
                            <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }} text-white">
                                {{ $item->status ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            {{-- Tombol Edit --}}
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditTA-{{ $item->id_ta }}">
                                <i class="fa fa-edit"></i>
                            </button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('tahun-ajaran.destroy', $item->id_ta) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="modalEditTA-{{ $item->id_ta }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('tahun-ajaran.update', $item->id_ta) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @include('tahun-ajaran.form', ['tahunAjaran' => $item])
                            </form>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Data Tahun Ajaran belum tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Keterangan jumlah --}}
            <p class="mt-2">
                Menampilkan {{ $tahunAjaran->count() }} dari {{ $tahunAjaran->total() }} data.
            </p>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $tahunAjaran->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahTA" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('tahun-ajaran.store') }}" method="POST">
            @csrf
            @include('tahun-ajaran.form', ['tahunAjaran' => new \App\Models\TahunAjaran(), 'nextId' => $nextId])
        </form>
    </div>
</div>
@endsection
