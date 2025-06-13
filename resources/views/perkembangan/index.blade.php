@extends('layouts.app')
@section('title', 'Data Perkembangan')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
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
            <h4>Data Perkembangan</h4>

            {{-- Form pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari indikator..."
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
                        <th>ID Perkembangan</th>
                        <th>Indikator</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perkembangan as $item)
                    <tr>
                        <td>{{ $item->id_perkembangan }}</td>
                        <td>{{ $item->indikator }}</td>
                        <td class="text-center">
                            {{-- Edit --}}
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $item->id_perkembangan }}">
                                <i class="fa fa-edit"></i>
                            </button>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEdit-{{ $item->id_perkembangan }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('perkembangan.update', $item->id_perkembangan) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Perkembangan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>ID Perkembangan</label>
                                                    <input type="text" class="form-control" value="{{ $item->id_perkembangan }}" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Indikator</label>
                                                    <input type="text" name="indikator" class="form-control" value="{{ $item->indikator }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-warning" type="submit">Update</button>
                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Hapus --}}
                            <form action="{{ route('perkembangan.destroy', $item->id_perkembangan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada data perkembangan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Keterangan jumlah --}}
            <p class="mt-2">Menampilkan {{ $perkembangan->count() }} dari {{ $perkembangan->total() }} Data Perkembangan</p>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $perkembangan->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>

            {{-- Modal Tambah --}}
            <div class="modal fade" id="modalTambah" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('perkembangan.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Perkembangan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>ID Perkembangan</label>
                                    <input type="text" name="id_perkembangan" class="form-control @error('id_perkembangan') is-invalid @enderror" value="{{ old('id_perkembangan') }}">
                                    @error('id_perkembangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label>Indikator</label>
                                    <input type="text" name="indikator" class="form-control" value="{{ old('indikator') }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit">Simpan</button>
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
