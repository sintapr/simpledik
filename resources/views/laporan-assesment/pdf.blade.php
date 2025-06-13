<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Assesment - {{ $siswa->nama_siswa }}</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            width: 100%;
            font-size: 14px;
        }

        .info td {
            padding: 4px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }

        .table th, .table td {
            padding: 8px;
            border: 1px solid #000;
            vertical-align: top;
        }

        .table th {
            background-color: #f5f5f5;
            text-align: left;
        }

        .section-title {
            margin-top: 30px;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
        }

        .footer div {
            width: 45%;
            text-align: center;
        }

        .footer strong {
            display: inline-block;
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

    </style>
</head>
<body>

    {{-- Header Kop Surat --}}
   <table style="width: 100%;">
    <tr>
        <td style="width: 90px;">
            <img src="{{ public_path('images/bgbro.png') }}" alt="Logo" style="width: 90px;">
        </td>
        <td style="text-align: left; padding-left: 15px;">
            <div style="font-size: 16pt; font-weight: bold;">
                Taman Kanak-kanak Islam “TARUNA AL QUR’AN”
            </div>
            <div style="font-size: 13pt;">
                Lempongsari, Sariharjo, Ngaglik, Sleman, Yogyakarta
            </div>
            <div style="font-size: 11pt;">
                Telp. 087838997479, 
                Email: <span style="color: blue;">kbtki_taruna_alquran@yahoo.com</span>, 
                Web: <span style="color: blue;">www.taruna-alquran.com</span>
            </div>
        </td>
    </tr>
</table>

<hr style="border: none; border-top: 3px double black; margin-top: 5px; margin-bottom: 15px;">




    <h2>LAPORAN HASIL BELAJAR</h2>

    <div class="info">
        <table>
            <tr>
                <td>Nama</td>
                <td>: {{ $siswa->nama_siswa }}</td>
                <td>Kelas</td>
                <td>: {{ $kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td>NIS/NISN</td>
                <td>: {{ $siswa->NIS }}/{{ $siswa->NISN }}</td>
                <td>Semester</td>
                <td>: {{ $tahunAjaran->semester }}</td>
            </tr>
            <tr>
                <td>Nama Sekolah</td>
                <td>: TK Islam Taruna Al Quran</td>
                <td>Tahun Pelajaran</td>
                <td>: {{ $tahunAjaran->tahun_ajaran }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td colspan="3">: Jl. Pengalusan, Sleman, Yogyakarta</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Penilaian Mingguan</div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tujuan Pembelajaran</th>
                <th>Konteks</th>
                <th>Tempat dan Waktu Muncul</th>
                <th>Kejadian Teramati</th>
                <th>Minggu</th>
                <th>Bulan</th>
                <th>Semester</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assesments as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->tujuan_pembelajaran->tujuan_pembelajaran ?? '-' }}</td>
                    <td>{{ $item->konteks }}</td>
                    <td>{{ $item->tempat_waktu }}</td>
                    <td>{{ $item->kejadian_teramati }}</td>
                    <td>{{ $item->minggu }}</td>
                    <td>{{ $item->bulan }}</td>
                    <td>{{ $item->semester }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Belum ada data penilaian</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div>
            Sleman, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            Guru Kelas<br>
            <strong>______________________</strong>
        </div>
    </div>
</body>
</html>
