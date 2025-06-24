@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Guru</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <strong>{{ $guru->nama_guru }}</strong>
            <span class="badge {{ $guru->status == 1 ? 'bg-success' : 'bg-danger' }}">
                {{ $guru->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
            </span>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">NIP</div>
                <div class="col-md-8">{{ $guru->NIP }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Nama Guru</div>
                <div class="col-md-8">{{ $guru->nama_guru }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Jabatan</div>
                <div class="col-md-8">
                    @php
                        $jabatan = [
                            'kepala_sekolah' => 'Kepala Sekolah',
                            'wali_kelas' => 'Wali Kelas',
                            'admin' => 'Admin',
                        ];
                    @endphp
                    {{ $jabatan[$guru->jabatan] ?? '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Tanggal Lahir</div>
                <div class="col-md-8">
                    {{ $guru->tgl_lahir ? \Carbon\Carbon::parse($guru->tgl_lahir)->format('d-m-Y') : '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Foto</div>
                <div class="col-md-8">
                    @if ($guru->foto)
                        <img src="{{ asset('storage/' . $guru->foto) }}" alt="Foto Guru" class="img-thumbnail rounded" style="max-width: 150px;">
                    @else
                        <span class="text-muted">Tidak ada foto.</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('guru.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('guru.edit', $guru->NIP) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection
