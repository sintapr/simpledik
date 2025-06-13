@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
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
            <h4>Data Siswa</h4>

            {{-- Form Pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIS..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <!-- Tombol Cari -->
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </form>

            {{-- Modal Tambah --}}
            <div class="modal fade" id="modalTambahSiswa" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('siswa.form', ['siswa' => new \App\Models\Siswa()])
                    </form>
                </div>
            </div>

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>NIS</th>
                            <th>NISN</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat Lahir</th>
                            <th>Tgl Lahir</th>
                            <th>Foto</th>
                            {{-- <th>Status</th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $item)
                            <tr>
                                <td class="text-center">{{ $item->NIS }}</td>
                                <td class="text-center">{{ $item->NISN }}</td>
                                <td class="text-center">{{ $item->NIK }}</td>
                                <td>{{ $item->nama_siswa }}</td>
                                <td>{{ $item->tempat_lahir }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($item->tgl_lahir)->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="rounded" width="80" height="80" style="object-fit: cover;">
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                {{-- Tombol Lihat Detail --}}
                                <a href="{{ route('siswa.show', $item->NIS) }}" class="btn btn-success btn-sm" title="Lihat Detail">
                                    <i class="fa fa-eye"></i>
                                </a>

                                {{-- Tombol Edit --}}
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditSiswa-{{ $item->NIS }}" title="Edit Siswa">
                                    <i class="fa fa-edit"></i>
                                </button>

                                {{-- Modal Edit --}}
                                <div class="modal fade" id="modalEditSiswa-{{ $item->NIS }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="{{ route('siswa.update', $item->NIS) }}" method="POST" enctype="multipart/form-data">
                                            @csrf @method('PUT')
                                            @include('siswa.form', ['siswa' => $item])
                                        </form>
                                    </div>
                                </div>

                                {{-- Hapus --}}
                                <form action="{{ route('siswa.destroy', $item->NIS) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Siswa">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Info Jumlah --}}
            <p class="mt-3">
                Menampilkan {{ $siswa->count() }} dari {{ $siswa->total() }} Data Siswa.
            </p>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $siswa->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
