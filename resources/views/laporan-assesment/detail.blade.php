@extends('layouts.app')
@section('title', 'Laporan Assessment Siswa')
@section('content')

<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <h4 class="mb-0">@yield('title')</h4>
        <p class="mb-0">Nama Siswa: <strong>{{ $siswa->nama_siswa }}</strong></p>
        <p class="mb-0">Kelas: <strong>{{ $kelas->nama_kelas ?? '-' }}</strong></p>
        <p class="mb-0">Tahun Ajaran: <strong>{{ $tahunAjaran->tahun_mulai }}/{{ $tahunAjaran->tahun_selesai }} - Semester {{ $tahunAjaran->semester }}</strong></p>
    </div>
</div>

<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-body">
            @php
                $grouped = $assesments->groupBy('minggu');
            @endphp

            @forelse ($grouped as $minggu => $mingguan)
                <h5 class="mt-4">Minggu ke-{{ $minggu }}</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Tujuan Pembelajaran</th>
                                <th>Konteks</th>
                                <th>Tempat & Waktu</th>
                                <th>Kejadian Teramati</th>
                                <th class="text-center">Bulan</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Sudah Muncul</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mingguan as $item)
                                <tr>
                                    <td>{{ $item->tujuan_pembelajaran->tujuan_pembelajaran ?? $item->id_tp }}</td>
                                    <td>{{ $item->konteks }}</td>
                                    <td>{{ $item->tempat_waktu }}</td>
                                    <td>{{ $item->kejadian_teramati }}</td>
                                    <td class="text-center">{{ $item->bulan }}</td>
                                    <td class="text-center">{{ $item->tahun }}</td>
                                    <td class="text-center">{{ $item->sudah_muncul ? 'Ya' : 'Tidak' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                <p class="text-danger">Data assessment belum tersedia.</p>
            @endforelse

            <a href="{{ route('laporan-assesment.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Kelas</a>
        </div>
    </div>
</div>

@endsection
