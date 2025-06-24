@extends('layouts.app')

@section('title', 'Detail Laporan Perkembangan Siswa')

@push('styles')
<style>
    .section-title {
        font-weight: bold;
        font-size: 1.1rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        border-left: 5px solid #000;
        padding-left: 10px;
        background-color: #f0f0f0;
    }
       .foto-cp, .foto-p5 {
       max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border: 1px solid #000;
    }
    .signature-box {
        min-height: 80px;
        border-bottom: 1px dotted #000;
        display: inline-block;
        width: 100%;
        margin-top: 40px;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <h3 class="text-center fw-bold">LAPORAN PERKEMBANGAN PESERTA DIDIK</h3>
    <h5 class="text-center mb-4">TAMAN KANAK-KANAK ISLAM TARUNA AL QURAN</h5>

    {{-- IDENTITAS --}}
    <table class="table table-sm table-borderless w-75 mx-auto mb-4">
        <tr><th class="w-50">Nama Sekolah</th><td>: TK Islam Taruna Al Quran</td></tr>
        <tr><th>Kelas</th><td>: {{ $rapor->kelas->nama_kelas ?? '-' }}</td></tr>
        <tr><th>Nama Siswa</th><td>: {{ $siswa->nama_siswa }}</td></tr>
        <tr><th>Fase</th><td>: {{ $rapor->fase->nama_fase ?? '-' }}</td></tr>
        <tr><th>Tahun Ajaran</th><td>: {{ $tahunAjaran->tahun_mulai }}</td></tr>
        <tr><th>Semester</th><td>: {{ $rapor->semester == 1 ? 'I (Satu)' : 'II (Dua)' }}</td></tr>
    </table>

    {{-- TAHFIDZ --}}
    <h5 class="section-title">Hafalan Surat-surat Pendek (Tahfidz Juz 30)</h5>
    <table class="table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>No</th><th>Surat</th><th>Nilai</th>
                <th>No</th><th>Surat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hafalan->chunk(3) as $chunk)
            <tr>
                @foreach($chunk as $i => $h)
                    <td>{{ $loop->parent->iteration * 3 - 3 + $i + 1 }}</td>
                    <td>{{ $h->surat->nama_surat ?? '-' }}</td>
                    <td>{{ $h->nilai }}</td>
                @endforeach
                @for ($i = $chunk->count(); $i < 3; $i++)
                    <td colspan="3"></td>
                @endfor
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TARBIYAH --}}
    <h5 class="section-title">Tarbiyah dan BTQ</h5>
    <table class="table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Indikator</th>
                <th>Materi</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tarbiyah as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->materi && $t->materi->indikator ? $t->materi->indikator->indikator : 'Lainnya' }}</td>
                <td>{{ $t->materi->materi ?? '-' }}</td>
                <td>{{ $t->nilai }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- CP --}}
    <h5 class="section-title">Laporan Perkembangan Capaian Pembelajaran</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Indikator</th>
                <th>Aspek</th>
                <th>Deskripsi</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cp as $c)
            <tr>
                <td>{{ $c->penilaian->perkembangan->indikator ?? '-' }}</td>
                <td>{{ $c->penilaian->aspek_nilai ?? '-' }}</td>
                <td>{!! $c->nilai !!}</td>
                <td>
                    @if($c->foto)
                        <img src="{{ asset('storage/' . $c->foto) }}" style="max-width: 100px; max-height: 100px; object-fit: cover; border: 1px solid #000;">
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- P5 --}}
    <h5 class="section-title">Projek Penguatan Profil Pelajar Pancasila</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Indikator</th>
                <th>Deskripsi</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($p5 as $p)
            <tr>
                <td>{{ $p->perkembangan->indikator ?? '-' }}</td>
                <td>{!! $p->nilai !!}</td>
                <td>
                    @if($p->foto)
                        {{-- <img src="{{ asset('storage/foto_nilai_p5/' . $p->foto) }}" class="foto-p5"> --}}
                        <img src="{{ asset('storage/foto_nilai_p5/' . $p->foto) }}" style="max-width: 100px; max-height: 100px; object-fit: cover; border: 1px solid #000;">
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <h5 class="section-title">Tanda Tangan</h5>
    <div class="row text-center my-4">
        <div class="col-md-4">
            Orang Tua / Wali
            <div class="signature-box"></div>
        </div>
        <div class="col-md-4">
            Sleman, {{ now()->translatedFormat('d F Y') }}<br>Guru Kelas
            <div class="signature-box">
                ({{ $rapor->guru->nama ?? '_____________________' }})
            </div>
        </div>
        <div class="col-md-4">
            Kepala Sekolah
            <div class="signature-box">
                (SUPARYATI, S.Pd. AUD.)
            </div>
        </div>
    </div>

    {{-- TOMBOL CETAK --}}
    <div class="text-center mt-5">
        <a href="{{ route('laporan-semester.laporan.cetak', [$siswa->NIS, $tahunAjaran->id_ta, $tahunAjaran->semester]) }}"
           class="btn btn-success" target="_blank">
            Cetak PDF
        </a>
    </div>
</div>
@endsection
