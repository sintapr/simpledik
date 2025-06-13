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
                $grouped = $assesments->groupBy(function($item) {
                    return $item->minggu . '-' . $item->bulan . '-' . $item->semester . '-' . $item->tahun;
                });
            @endphp

            @if ($grouped->isEmpty())
                <p class="text-danger">Data assessment belum tersedia.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">Minggu</th>
                                <th class="text-center">Bulan</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grouped as $key => $items)
                                @php
                                    $first = $items->first();
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $first->minggu }}</td>
                                    <td class="text-center">{{ $first->bulan }}</td>
                                    <td class="text-center">{{ $first->semester }}</td>
                                    <td class="text-center">{{ $first->tahun }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('laporan-assesment.cetak.mingguan', [$siswa->NIS, $kelas->id_kelas, $tahunAjaran->id_ta, $first->minggu]) }}"
                                           target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fa fa-print"></i> Cetak PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <a href="{{ route('laporan-assesment.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Kelas</a>

        </div>
    </div>
</div>
@endsection
