@extends('layouts.app')
@section('title', 'Data Kelas')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
            <i class="fa fa-plus"></i> Tambah Kelas
        </button>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Kelas</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <h4>Data Kelas</h4>

            {{-- Form pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama kelas..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Kelas</th>
                        <th>Nama Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kelas as $item)
                        <tr>
                            <td>{{ $item->id_kelas }}</td>
                            <td>{{ $item->nama_kelas }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditKelas-{{ $item->id_kelas }}">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="modalEditKelas-{{ $item->id_kelas }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="{{ route('kelas.update', $item->id_kelas) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Kelas</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>ID Kelas</label>
                                                        <input type="text" name="id_kelas" class="form-control" value="{{ $item->id_kelas }}" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nama Kelas</label>
                                                        <input type="text" name="nama_kelas" class="form-control" value="{{ $item->nama_kelas }}">
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

                                <!-- Tombol Hapus -->
                                <form action="{{ route('kelas.destroy', $item->id_kelas) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada data kelas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Keterangan jumlah --}}
        <p class="mt-2">
            Menampilkan {{ $kelas->count() }} dari {{ $kelas->total() }} Data Kelas
        </p>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $kelas->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>

                </div>
            </div>
        </div>

<!-- Modal Tambah -->
@php
    $last = $kelas->sortByDesc('id_kelas')->first();
    $newId = $last ? 'K' . str_pad((int)substr($last->id_kelas, 1) + 1, 3, '0', STR_PAD_LEFT) : 'K001';
@endphp

<div class="modal fade" id="modalTambahKelas" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>ID Kelas</label>
                        <input type="text" name="id_kelas" class="form-control" value="{{ $newId }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" required>
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
@endsection
