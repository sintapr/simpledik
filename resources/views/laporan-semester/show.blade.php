@extends('layouts.app')

@section('title', 'Detail Laporan Perkembangan Siswa')

@section('content')
<div class="container">
    <h3 class="text-center">LAPORAN PERKEMBANGAN PESERTA DIDIK</h3>
    <h4 class="text-center mb-4">TAMAN KANAK-KANAK ISLAM TARUNA AL QURAN</h4>

    <table class="table table-borderless">
        <tr><th>Nama Sekolah</th><td>: TK Islam Taruna Al Quran</td></tr>
        <tr><th>Kelas</th><td>: {{ $rapor->kelas->nama_kelas ?? '-' }}</td></tr>
        <tr><th>Nama Siswa</th><td>: {{ $siswa->nama_siswa }}</td></tr>
        <tr><th>Fase</th><td>: {{ $rapor->fase->nama_fase ?? '-' }}</td></tr>
        <tr><th>Tahun Ajaran</th><td>: {{ $tahunAjaran->tahun_mulai }}</td></tr>
        <tr><th>Semester</th><td>: {{ $rapor->semester == 1 ? 'I (Satu)' : 'II (Dua)' }}</td></tr>
    </table>

    <hr>

    <h5>HAFALAN SURAT-SURAT PENDEK (TAHFIDZ JUZ 30)</h5>
    <table class="table table-bordered">
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

    <h5 class="mt-4">TARBIYAH DAN BTQ</h5>
    <table class="table table-bordered">
        <thead>
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
                <td>{{ $t->materi->indikator ?? '-' }}</td>
                <td>{{ $t->materi->materi ?? '-' }}</td>
                <td>{{ $t->nilai }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h5 class="mt-4">LAPORAN PERKEMBANGAN ELEMEN CAPAIAN PERKEMBANGAN</h5>
    @foreach($cp as $c)
        <p>{{ $c->nilai }}</p>
    @endforeach

    <h5 class="mt-4">PROJEK PENGUATAN PROFIL PELAJAR PANCASILA</h5>
    @foreach($p5 as $p)
        <p>{{ $p->nilai }}</p>
    @endforeach

    <h5 class="mt-4">TANDA TANGAN</h5>
    <div class="row text-center">
        <div class="col-md-4">Orang Tua / Wali<br><br><br>(_____________________)</div>
        <div class="col-md-4">
            Sleman, {{ now()->translatedFormat('d F Y') }}<br>
            Guru Kelas<br><br><br>({{ $rapor->guru->nama ?? '_____________________' }})
        </div>
        <div class="col-md-4">Kepala Sekolah<br><br><br>(SUPARYATI, S.Pd. AUD.)</div>
    </div>

    <div class="mt-5 text-center">
<a href="{{ route('laporan-semester.laporan.cetak', [$siswa->NIS, $tahunAjaran->id_ta, $tahunAjaran->semester]) }}"
   class="btn btn-success mb-3" target="_blank">
   Cetak PDF
</a>
    </div>
</div>
@endsection
