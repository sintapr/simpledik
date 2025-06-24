@extends('layouts.app')
@section('title', 'Data Assesment')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <a href="{{ route('assesment.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Assesment</a>
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
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari nama siswa atau tujuan..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </form>

            <<div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-sm">
                <thead class="text-center table-primary">
            <tr>
                <th style="width: 5%">ID</th>
                <th style="width: 10%">NIS</th>
                <th style="width: 20%">Tujuan</th>
                <th style="width: 10%">Konteks</th>
                <th style="width: 15%">Tempat & Waktu</th>
                <th style="width: 20%">Kejadian</th>
                <th style="width: 5%">Minggu</th>
                <th style="width: 8%">Bulan</th>
                <th style="width: 7%">Semester</th>
                <th style="width: 7%">Tahun</th>
                <th style="width: 10%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assesment as $item)
                <tr>
                    <td class="text-center">{{ $item->id_assesment }}</td>
                    <td>{{ $item->siswa->nama_siswa ?? $item->NIS }}</td>
                    <td>{{ $item->tujuan_pembelajaran->tujuan_pembelajaran ?? $item->id_tp }}</td>
                    <td class="text-center">{{ $item->konteks }}</td>
                    <td>{{ $item->tempat_waktu }}</td>
                    <td>{{ $item->kejadian_teramati }}</td>
                    <td class="text-center">{{ $item->minggu }}</td>
                    <td class="text-center">{{ $item->bulan }}</td>
                    <td class="text-center">{{ $item->semester }}</td>
                    <td class="text-center">{{ $item->tahun }}</td>
                    <td class="text-center">
                        <a href="{{ route('assesment.edit', $item->id_assesment) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('assesment.destroy', $item->id_assesment) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="11" class="text-center">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

            {{-- Info & Pagination --}}
            <p class="mt-2">Menampilkan {{ $assesment->count() }} dari {{ $assesment->total() }} data</p>
            <div class="d-flex justify-content-center">
                {{ $assesment->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
