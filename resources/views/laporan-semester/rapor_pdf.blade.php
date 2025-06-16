<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor - {{ $siswa->nama_siswa }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 25px;
            color: #000;
        }

        h2 {
            text-align: center;
            text-transform: uppercase;
            margin: 10px 0 20px;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-top: 30px;
            margin-bottom: 8px;
            border-left: 5px solid #000;
            padding-left: 10px;
            background-color: #f5f5f5;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .info-table td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .table th, .table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .table th {
            background-color: #f0f0f0;
        }

        .arabic {
            direction: rtl;
            text-align: right;
            font-family: 'DejaVu Sans', serif;
            font-size: 14px;
            line-height: 2;
            margin-bottom: 10px;
        }

        .foto-cp, .foto-p5 {
            max-width: 90px;
            max-height: 90px;
            object-fit: cover;
            border: 1px solid #000;
        }

        .ttd-section {
            display: table;
            width: 100%;
            margin-top: 60px;
            text-align: center;
            font-size: 13px;
        }

        .ttd-col {
            display: table-cell;
            width: 33%;
            vertical-align: top;
        }

        .ttd-box {
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>

{{-- Header --}}
<table style="width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 90px;">
            <img src="{{ public_path('images/bgbro.png') }}" alt="Logo" style="width: 90px;">
        </td>
        <td style="text-align: left; padding-left: 15px;">
            <div style="font-size: 16pt; font-weight: bold;">TAMAN KANAK-KANAK ISLAM TARUNA AL QUR’AN</div>
            <div style="font-size: 12pt;">Lempongsari, Sariharjo, Ngaglik, Sleman, Yogyakarta</div>
            <div style="font-size: 10pt;">Telp. 087838997479 | Email: <span style="color: blue;">kbtki_taruna_alquran@yahoo.com</span> | Web: <span style="color: blue;">www.taruna-alquran.com</span></div>
        </td>
    </tr>
</table>

<hr style="border: none; border-top: 3px double black; margin: 10px 0 20px;">

<h2>Laporan Perkembangan Peserta Didik</h2>

{{-- IDENTITAS --}}
<table class="info-table">
    <tr><td>Nama</td><td>: {{ $siswa->nama_siswa }}</td><td>Kelas</td><td>: {{ $kelas->nama_kelas ?? '-' }}</td></tr>
    <tr><td>NIS / NISN</td><td>: {{ $siswa->NIS }} / {{ $siswa->NISN }}</td><td>Semester</td><td>: {{ $tahunAjaran->semester }}</td></tr>
    <tr><td>Tahun Ajaran</td><td colspan="3">: {{ $tahunAjaran->tahun_ajaran }}</td></tr>
</table>

{{-- MUQODDIMAH --}}
<div class="section-title">Muqoddimah</div>
<div class="arabic">{!! $muqoddimah !!}</div>

{{-- NARASI PEMBUKA --}}
<p style="margin-top: 20px;">
    Lembar ini adalah wadah berbagi TK Islam Taruna Al Quran dan Orang tua mengenai perkembangan Ananda selama bermain dan belajar di TK Islam Taruna Al Quran selama satu semester. Orang tua dan guru dapat mendiskusikan catatan-catatan mengenai perkembangan Anak berikut ini.
</p>

{{-- HAFALAN --}}
<div class="section-title">Hafalan Surat-surat Pendek (Tahfidz Juz 30)</div>
<table class="table">
    <thead><tr><th>No</th><th>Nama Surat</th><th>Nilai</th></tr></thead>
    <tbody>
        @foreach($hafalan as $i => $h)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $h->surat->nama_surat ?? '-' }}</td>
            <td>{{ $h->nilai }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- TARBIYAH DAN BTQ --}}
<div class="section-title">Tarbiyah dan BTQ</div>
@php $groupedTarbiyah = $tarbiyah->groupBy(fn($t) => $t->materi->indikatorTarbiyah->indikator ?? 'Lainnya'); @endphp
@foreach($groupedTarbiyah as $indikator => $list)
<p><strong>{{ $indikator }}</strong></p>
<table class="table">
    <thead><tr><th>No</th><th>Indikator</th><th>Materi</th><th>Nilai</th></tr></thead>
    <tbody>
        @foreach($list as $i => $item)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $item->materi->indikator->indikator ?? '-' }}</td>
            <td>{{ $item->materi->materi }}</td>
            <td>{!! $item->nilai ?? '-' !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endforeach

{{-- CAPAIAN PEMBELAJARAN --}}
<div class="section-title">Laporan Perkembangan Capaian Pembelajaran</div>
@php $kelompokCp = $cp->groupBy(fn($c) => $c->penilaian->perkembangan->indikator); @endphp
@foreach($kelompokCp as $indikator => $listCp)
<p><strong>{{ $indikator }}</strong></p>
<table class="table">
    <thead><tr><th>Capaian</th><th>Deskripsi</th><th>Foto</th></tr></thead>
    <tbody>
        @foreach($listCp as $c)
        <tr>
            <td>{{ $c->penilaian->aspek_nilai }}</td>
            <td>{!! $c->nilai !!}</td>
            <td>
                @if($c->foto)
                    <img src="{{ public_path('storage/' . $c->foto) }}" class="foto-cp">
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endforeach

{{-- P5 --}}
<div class="section-title">Projek Penguatan Profil Pelajar Pancasila</div>
@foreach($p5 as $p)
<p><strong>{{ $p->perkembangan->indikator ?? '-' }}</strong></p>
<table class="table">
    <tr>
        <td style="width: 70%">{!! $p->nilai !!}</td>
        <td style="width: 30%">
            @if($p->foto)
                <img src="{{ public_path('storage/foto_nilai_p5/' . $p->foto) }}" class="foto-p5">
            @endif
        </td>
    </tr>
</table>
@endforeach

{{-- TANDA TANGAN --}}
<div class="section-title">Tanda Tangan</div>
<div class="ttd-section">
    <div class="ttd-col">
        Orang Tua / Wali
        <div class="ttd-box">
            ({{ $siswa->orangtua->nama_ayah ?? '..........................................' }})
        </div>
    </div>
    <div class="ttd-col">
        Sleman, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Guru Kelas
        <div class="ttd-box">
            ({{ $waliKelas->guru->nama ?? '.............................' }})
        </div>
    </div>
    <div class="ttd-col">
        Kepala Sekolah
        <div class="ttd-box">
            (SUPARYATI, S.Pd. AUD.)
        </div>
    </div>
</div>

</body>
</html>
