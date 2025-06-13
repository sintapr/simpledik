@extends('layouts.app')

@section('title', 'Data Guru')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <!-- Tombol Tambah -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahGuru">
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
            <h4>Data Guru</h4>

            {{-- Form pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIP..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <!-- Tombol Cari -->
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </form>

            {{-- Modal Tambah Guru --}}
            <div class="modal fade" id="modalTambahGuru" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('guru.form', ['guru' => null])
                    </form>
                </div>
            </div>

            {{-- Tabel --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Tanggal Lahir</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guru as $item)
                    <tr>
                        <td>{{ $item->NIP }}</td>
                        <td>{{ $item->nama_guru }}</td>
                        <td>{{ $item->jabatan }}</td>
                        <td>{{ $item->tgl_lahir->format('d-m-Y') }}</td>
                        <td>
                            @if ($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" width="80" class="rounded">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }} text-white">
                                {{ $item->status ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            {{-- Lihat detail hanya admin --}}
                            @if (auth('guru')->check() && auth('guru')->user()->jabatan === 'admin')
                                <a href="{{ route('guru.show', $item->NIP) }}" class="btn btn-success btn-sm" title="Lihat Detail">
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endif

                            {{-- Edit --}}
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditGuru-{{ $item->NIP }}">
                                <i class="fa fa-edit"></i>
                            </button>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEditGuru-{{ $item->NIP }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('guru.update', $item->NIP) }}" method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        @include('guru.form', ['guru' => $item])
                                    </form>
                                </div>
                            </div>

                            {{-- Hapus --}}
                            <form action="{{ route('guru.destroy', $item->NIP) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data guru</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Keterangan jumlah --}}
            <p class="mt-2">
                Menampilkan {{ $guru->count() }} dari {{ $guru->total() }} Data Guru
            </p>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
    {{ $guru->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>

        </div>
    </div>
</div>
@endsection
