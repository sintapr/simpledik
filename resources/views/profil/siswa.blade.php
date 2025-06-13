@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Profil Orang Tua</h3>
    <div class="card">
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
                </tr>
            </table>
            <a href="{{ route('profil.edit') }}" class="btn btn-primary mt-3">Edit Profil</a>
        </div>
    </div>
</div>
@endsection
