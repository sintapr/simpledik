@extends('layouts.app') 

{{-- @section('title', 'Detail Siswa') --}}

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <h4 class="mb-0">@yield('title')</h4>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Data Siswa</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <strong>Data Siswa</strong>
        </div>

        <div class="card-body">
            {{-- Identitas Siswa --}}
            <div class="row mb-3">
                <div class="col-md-3 fw-bold text-end">NIS</div>
                <div class="col-md-9">{{ $siswa->NIS }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold text-end">Nama Lengkap</div>
                <div class="col-md-9">{{ $siswa->nama_siswa }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold text-end">Jenis Kelamin</div>
                <div class="col-md-9">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold text-end">Tanggal Lahir</div>
                <div class="col-md-9">
                    {{ $siswa->tgl_lahir ? \Carbon\Carbon::parse($siswa->tgl_lahir)->format('d-m-Y') : '-' }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold text-end">Alamat</div>
                <div class="col-md-9">{{ $siswa->alamat ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold text-end">Foto</div>
                <div class="col-md-9">
                    @if ($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto {{ $siswa->nama_siswa }}" class="rounded" width="120" height="120" style="object-fit: cover;">
                    @else
                        <span class="text-muted">Tidak ada foto.</span>
                    @endif
                </div>
            </div>

            {{-- Data Orangtua --}}
            <hr>
            <h5 class="mt-4 mb-3">Data Orangtua</h5>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold text-end">Nama Ayah</div>
                <div class="col-md-9">{{ $siswa->orangtua->nama_ayah ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold text-end">Nama Ibu</div>
                <div class="col-md-9">{{ $siswa->orangtua->nama_ibu ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold text-end">Pekerjaan Ayah</div>
                <div class="col-md-9">{{ $siswa->orangtua->pekerjaan_ayah ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold text-end">Pekerjaan Ibu</div>
                <div class="col-md-9">{{ $siswa->orangtua->pekerjaan_ibu ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold text-end">Alamat</div>
                <div class="col-md-9">{{ $siswa->orangtua->alamat ?? '-' }}</div>
            </div>

            {{-- Data Wali Kelas --}}
            <hr>
            <h5 class="mt-4 mb-3">Data Wali Kelas & Kelas</h5>
            @php
                $anggota = $siswa->anggota_kelas->first();
                $wali = $anggota->waliKelas ?? null;
            @endphp

            @if ($wali)
                <div class="row mb-2">
                    <div class="col-md-3 fw-bold text-end">Nama Wali Kelas</div>
                    <div class="col-md-9">{{ $wali->guru->nama_guru ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 fw-bold text-end">Jabatan Wali Kelas</div>
                    <div class="col-md-9">{{ $wali->guru->jabatan ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 fw-bold text-end">Kelas</div>
                    <div class="col-md-9">{{ $wali->kelas->nama_kelas ?? '-' }}</div>
                </div>
            @else
                <div class="text-muted">Data wali kelas belum tersedia.</div>
            @endif
        </div>

        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('siswa.edit', $siswa->NIS) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection
