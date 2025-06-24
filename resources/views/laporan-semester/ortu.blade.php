@extends('layouts.app')

@section('title', 'Laporan Semester')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <h4 class="mb-0">Daftar Rapor - {{ $siswa->nama_siswa }}</h4>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Semester</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Rapor Siswa</h5>

            @if($raporSemester->isEmpty())
                <div class="alert alert-warning mt-3">Belum ada rapor yang tersedia.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Semester</th>
                                <th>Tahun Ajaran</th>
                                <th>Kelas</th>
                                <th>Cetak PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($raporSemester as $rapor)
                                @php
                                    $ta = $rapor->tahunAjaran ?? null;
                                    $kelas = $rapor->kelas ?? null;
                                    $semester = $ta->semester ?? '-';
                                    $tahunMulai = $ta->tahun_mulai ?? '-';
                                    $tahunSelesai = $ta->tahun_selesai ?? '-';
                                    $id_ta = $ta->id_ta ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $semester }}</td>
                                    <td>{{ $tahunMulai }} / {{ $tahunSelesai }}</td>
                                    <td>{{ $kelas->nama_kelas ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('laporan-semester.laporan.cetak', [$siswa->NIS, $id_ta, $semester]) }}" target="_blank" class="btn btn-sm btn-primary">
                                            Cetak PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
