@extends('layouts.app')
@section('title', 'Surat Hafalan')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahSuratHafalan">
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
            <h4>Data Surat Hafalan</h4>

            <!-- Modal Tambah -->
            <div class="modal fade" id="modalTambahSuratHafalan" tabindex="-1" aria-labelledby="modalTambahSuratHafalanLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('surat-hafalan.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Surat Hafalan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>ID Surat</label>
                                    <input type="text" name="id_surat" class="form-control" value="{{ $newId }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Nama Surat</label>
                                    <input type="text" name="nama_surat" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Perkembangan</label>
                                    <select name="id_perkembangan" class="form-control" required>
                                        <option value="">Pilih Perkembangan</option>
                                        @foreach ($perkembangan as $p)
                                            <option value="{{ $p->id_perkembangan }}">{{ $p->indikator }}</option>
                                        @endforeach
                                    </select>
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

            {{-- Form Pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama surat, id surat, atau indikator..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>                
                </div>
            </form>

            <!-- Tabel Data -->
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID Surat</th>
                        <th>Nama Surat</th>
                        <th>Perkembangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suratHafalan as $item)
                        <tr>
                            <td>{{ $item->id_surat }}</td>
                            <td>{{ $item->nama_surat }}</td>
                            <td>{{ $item->perkembangan->indikator ?? '-' }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $item->id_surat }}">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="modalEdit-{{ $item->id_surat }}" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('surat-hafalan.update', $item->id_surat) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Surat Hafalan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>ID Surat</label>
                                                        <input type="text" name="id_surat" class="form-control" value="{{ $item->id_surat }}" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nama Surat</label>
                                                        <input type="text" name="nama_surat" class="form-control" value="{{ $item->nama_surat }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Perkembangan</label>
                                                        <select name="id_perkembangan" class="form-control" required>
                                                            @foreach ($perkembangan as $p)
                                                                <option value="{{ $p->id_perkembangan }}"
                                                                    @if ($item->id_perkembangan == $p->id_perkembangan) selected @endif>
                                                                    {{ $p->indikator }}
                                                                </option>
                                                            @endforeach
                                                        </select>
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
                                <form action="{{ route('surat-hafalan.destroy', $item->id_surat) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
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

        <p class="mt-2">
            Menampilkan {{ $suratHafalan->count() }} dari total {{ $suratHafalan->total() }} data
        </p>

        <div class="d-flex justify-content-center">
            {{ $suratHafalan->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>

        </div>
    </div>
</div>
@endsection
