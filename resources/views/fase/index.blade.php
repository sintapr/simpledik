@extends('layouts.app')

@section('title', 'Data Fase')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <!-- Tombol Tambah -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahFase">
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
            <h4>Data Fase</h4>

            {{-- Form pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama fase..."
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
                        <th>ID Fase</th>
                        <th>Nama Fase</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fase as $item)
                    <tr>
                        <td>{{ $item->id_fase }}</td>
                        <td>{{ $item->nama_fase }}</td>
                        <td class="text-center">
                            {{-- Edit --}}
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditFase-{{ $item->id_fase }}">
                                <i class="fa fa-edit"></i>
                            </button>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEditFase-{{ $item->id_fase }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('fase.update', $item->id_fase) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Fase</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>ID Fase</label>
                                                    <input type="text" name="id_fase" class="form-control" value="{{ $item->id_fase }}" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Nama Fase</label>
                                                    <input type="text" name="nama_fase" class="form-control" value="{{ $item->nama_fase }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-warning">Update</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Hapus --}}
                            <form action="{{ route('fase.destroy', $item->id_fase) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada data fase</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Keterangan jumlah --}}
            <p class="mt-2">Menampilkan {{ $fase->count() }} dari {{ $fase->total() }} Data Fase</p>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $fase->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>

            {{-- Modal Tambah --}}
            <div class="modal fade" id="modalTambahFase" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('fase.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Fase</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>ID Fase</label>
                                    <input type="text" name="id_fase" class="form-control @error('id_fase') is-invalid @enderror" value="{{ old('id_fase') }}" required>
                                    @error('id_fase')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label>Nama Fase</label>
                                    <input type="text" name="nama_fase" class="form-control @error('nama_fase') is-invalid @enderror" value="{{ old('nama_fase') }}" required>
                                    @error('nama_fase')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
