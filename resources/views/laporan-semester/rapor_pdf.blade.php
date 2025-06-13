<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapor PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            margin: 30px;
            color: #000;
        }
        .arabic {
        direction: rtl;
        text-align: right;
        font-family: 'Amiri', 'Traditional Arabic', 'Scheherazade', 'DejaVu Sans', sans-serif;
        font-size: 14px;
        line-height: 2;
    }
        .center { text-align: center; }
        .header img { margin-bottom: 5px; }
        .header h3, .header h4, .header p { margin: 3px 0; }
        h4.section-title {
            font-weight: bold;
            font-size: 13px;
            margin: 20px 0 8px;
            text-transform: uppercase;
            border-left: 5px solid #000;
            padding-left: 8px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }
        .no-border td {
            border: none;
            padding: 4px 2px;
        }
        .signature td {
            text-align: center;
            border: none;
            padding-top: 60px;
            font-size: 11px;
        }
        .signature td strong {
            text-decoration: underline;
        }
        .foto-siswa {
            width: 100px;
            height: 130px;
            object-fit: cover;
            border: 1px solid #000;
            display: block;
            margin: 0 auto 10px;
        }
        .foto-cp, .foto-p5 {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border: 1px solid #000;
        }
        .identitas-foto {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .identitas { width: 65%; }
        .foto { width: 30%; text-align: center; }
        .foto img {
            width: 100px;
            height: 130px;
            object-fit: cover;
            border: 1px solid #000;
        }
    </style>
</head>
<body>
<div class="center header">
    <img src="{{ public_path('images/bgbro.png') }}" width="70">
    <h3>TAMAN KANAK-KANAK ISLAM TARUNA AL QURAN</h3>
    <p>Jl. Lempongsari 4A, Sariharjo, Ngaglik, Sleman Yogyakarta 55581</p>
    <h4 style="margin-top: 10px;">LAPORAN PERKEMBANGAN PESERTA DIDIK</h4>
</div>

<div class="identitas-foto">
    <div class="identitas">
        <h4 class="section-title">Identitas Siswa</h4>
        <table class="no-border">
            <tr><td>Nama Lengkap</td><td>: {{ $siswa->nama_siswa }}</td></tr>
            <tr><td>NIK</td><td>: {{ $siswa->NIK }}</td></tr>
            <tr><td>Tempat & Tgl Lahir</td><td>: {{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tgl_lahir)->translatedFormat('d F Y') }}</td></tr>
            <tr><td>Jenis Kelamin</td><td>: {{ $siswa->jenis_kelamin }}</td></tr>
            <tr><td>Agama</td><td>: Islam</td></tr>
            <tr><td>Anak ke</td><td>: {{ $siswa->anak_ke ?? '-' }}</td></tr>
            <tr><td>Jumlah Saudara</td><td>: {{ $siswa->jumlah_saudara ?? '-' }}</td></tr>
        </table>
    </div>
    <div class="foto">
        <img src="{{ public_path('storage/' . $siswa->foto) }}" class="foto-siswa">
    </div>
</div>

<h4 class="section-title">Muqoddimah</h4>
<div class="arabic">
    {!! $muqoddimah !!}
</div>


<h4 class="section-title">Hafalan Surat Pendek</h4>
<table>
    <thead>
        <tr><th>No</th><th>Nama Surat</th><th>Nilai</th></tr>
    </thead>
    <tbody>
        @foreach($hafalan as $i => $h)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $h->surat->nama_surat ?? '-' }}</td>
            <td>{!! $h->nilai ?? '-' !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h4 class="section-title">Tarbiyah dan BTQ</h4>
@php $groupedTarbiyah = $tarbiyah->groupBy(fn($t) => $t->materi->indikatorTarbiyah->indikator ?? 'Lainnya'); @endphp
@foreach($groupedTarbiyah as $indikator => $list)
    <p style="font-weight: bold;">{{ $indikator }}</p>
    <table>
        <thead><tr><th>No</th><th>Indikator</th><th>Materi</th><th>Nilai</th></tr></thead>
        <tbody>
            @foreach($list as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $item->materi && $item->materi->indikator ? $item->materi->indikator->indikator : 'Lainnya' }}</td>
                <td>{{ $item->materi->materi }}</td>
                <td>{!! $item->nilai ?? '-' !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endforeach

<h4 class="section-title">Capaian Pembelajaran</h4>
@php $kelompokCp = $cp->groupBy(fn($c) => $c->penilaian->perkembangan->indikator); @endphp
@foreach($kelompokCp as $indikator => $listCp)
    <p style="font-weight: bold;">{{ $indikator }}</p>
    <table>
        <thead><tr><th>Capaian</th><th>Deskripsi</th><th>Foto</th></tr></thead>
        <tbody>
            @foreach($listCp as $c)
            <tr>
                <td>{{ $c->penilaian->aspek_nilai }}</td>
                <td>{!! $c->nilai ?? '-' !!}</td>
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

<h4 class="section-title">P5 (Profil Pelajar Pancasila)</h4>
@foreach($p5 as $i => $item)
    <p style="font-weight: bold;">{{ $item->perkembangan->indikator ?? '-' }}</p>
    <table>
        <tr>
            <td style="width: 70%">{!! $item->nilai !!}</td>
            <td style="width: 30%">
                @if($item->foto)
                    <img src="{{ public_path('storage/foto_nilai_p5/' . $item->foto) }}" class="foto-p5">
                @endif
            </td>
        </tr>
    </table>
@endforeach

<h4 class="section-title">Kesehatan</h4>
<table>
    <thead><tr><th>BB (kg)</th><th>TB (cm)</th><th>LK (cm)</th><th>Penglihatan</th><th>Pendengaran</th><th>Gigi</th></tr></thead>
    <tbody>
        <tr>
            <td>{{ $kondisi->berat_badan ?? '-' }}</td>
            <td>{{ $kondisi->tinggi_badan ?? '-' }}</td>
            <td>{{ $kondisi->lingkar_kepala ?? '-' }}</td>
            <td>{{ $kondisi->penglihatan ?? '-' }}</td>
            <td>{{ $kondisi->pendengaran ?? '-' }}</td>
            <td>{{ $kondisi->kesehatan_gigi ?? '-' }}</td>
        </tr>
    </tbody>
</table>

<h4 class="section-title">Absensi</h4>
<table>
    <thead><tr><th>Sakit</th><th>Izin</th><th>Alpa</th></tr></thead>
    <tbody>
        <tr>
            <td>{{ $absensi->sakit ?? 0 }}</td>
            <td>{{ $absensi->izin ?? 0 }}</td>
            <td>{{ $absensi->alpa ?? 0 }}</td>
        </tr>
    </tbody>
</table>

<table class="signature">
    <tr>
        <td>Orang Tua/Wali</td>
        <td>Guru Kelas</td>
        <td>Kepala Sekolah</td>
    </tr>
    <tr><td style="height: 70px;"></td><td></td><td></td></tr>
    <tr>
        <td><strong>{{ $siswa->orangtua->nama_ayah ?? '-' }}</strong></td>
        <td><strong>{{ $waliKelas->nama_guru ?? '-' }}</strong></td>
        <td><strong>{{ $kepalaSekolah->nama_guru ?? '-' }}</strong></td>
    </tr>
</table>

</body>
</html>
