@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">Informasi Orangtua</div>
        <div class="card-body">
            <table class="table">
                <tr><th>NIS</th><td>{{ $user->NIS }}</td></tr>
                <tr><th>Nama Siswa</th><td>{{ $user->nama_siswa }}</td></tr>
                <tr><th>Tanggal Lahir</th><td>{{ $user->tgl_lahir->format('Y-m-d') }}</td></tr>
                <tr>
                    <th>Foto</th>
                    <td>
                        @if ($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto" height="100"
                            onerror="this.src='{{ asset('images/user/default.png') }}'">
                        @else
                            <em>Tidak ada foto</em>
                        @endif
                    </td>
                    <tr><th>Nama Ayah</th><td>{{ $user->orangtua->nama_ayah ?? '-' }}</td></tr>
                <tr><th>Pekerjaan Ayah</th><td>{{ $user->orangtua->pekerjaan_ayah ?? '-' }}</td></tr>
                <tr><th>Nama Ibu</th><td>{{ $user->orangtua->nama_ibu ?? '-' }}</td></tr>
                <tr><th>Pekerjaan Ibu</th><td>{{ $user->orangtua->pekerjaan_ibu ?? '-' }}</td></tr>
                <tr><th>Alamat</th><td>{{ $user->orangtua->alamat ?? '-' }}</td></tr>
                </tr>
            </table>
            {{-- <a href="{{ route('profil.edit') }}" class="btn btn-primary mt-3">Edit Profil</a> --}}
        </div>
    </div>

    {{-- Informasi Wali Kelas --}}
    @php
        $anggota = $user->anggotaKelas->first();
        $wali = $anggota->waliKelas ?? null;
    @endphp
    <div class="card">
        <div class="card-header bg-info text-white">Informasi Wali Kelas</div>
        <div class="card-body">
            @if ($wali)
                <table class="table">
                    <tr><th>Nama Wali Kelas</th><td>{{ $wali->guru->nama_guru ?? '-' }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $wali->guru->jabatan ?? '-' }}</td></tr>
                    <tr><th>Kelas</th><td>{{ $wali->kelas->nama_kelas ?? '-' }}</td></tr>
                </table>
            @else
                <p class="text-muted">Data wali kelas belum tersedia.</p>
            @endif
        </div>
    </div>
</div>
@endsection
