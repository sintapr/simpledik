@extends('layouts.app')
@section('title', 'Tujuan Pembelajaran')

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
            <li class="breadcrumb-item active"><a href="{{ route('tujuan.index') }}">@yield('title')</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4>Data Tujuan Pembelajaran</h4>

            {{-- Form Pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari tujuan pembelajaran..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit"><i class="fa fa-search"></i> Cari</button>
                </div>
            </form>

            {{-- Modal Tambah --}}
            @include('tujuan_pembelajaran.form', [
                'action' => route('tujuan.store'),
                'method' => 'POST',
                'modalId' => 'modalTambah',
                'title' => 'Tambah Tujuan Pembelajaran',
            ])

            {{-- Tabel Data --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID TP</th>
                        <th>Tujuan Pembelajaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tujuan as $item)
                        <tr>
                            <td>{{ $item->id_tp }}</td>
                            <td>{{ $item->tujuan_pembelajaran }}</td>
                            <td>
                                <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }} text-white">
                                    {{ $item->status ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit-{{ $item->id_tp }}">
                                    <i class="fa fa-edit"></i>
                                </a>

                                {{-- Modal Edit --}}
                                @include('tujuan_pembelajaran.form', [
                                    'action' => route('tujuan.update', $item->id_tp),
                                    'method' => 'PUT',
                                    'modalId' => 'modalEdit-' . $item->id_tp,
                                    'title' => 'Edit Tujuan Pembelajaran',
                                    'data' => $item,
                                ])

                                <!-- Tombol Hapus -->
                                <form action="{{ route('tujuan.destroy', $item->id_tp) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                            <td colspan="4" class="text-center">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Info dan Pagination --}}
            <p class="mt-2">Menampilkan {{ $tujuan->count() }} dari {{ $tujuan->total() }} data</p>
            <div class="d-flex justify-content-center">
                {{ $tujuan->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
