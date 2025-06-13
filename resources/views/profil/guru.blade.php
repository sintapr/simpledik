@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Profil Guru</h3>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <tr><th>NIP</th><td>{{ $user->NIP }}</td></tr>
                <tr><th>Nama</th><td>{{ $user->nama_guru }}</td></tr>
                <tr><th>Jabatan</th><td>{{ $user->jabatan }}</td></tr>
                <tr><th>Tanggal Lahir</th><td>{{ $user->tgl_lahir->format('d-m-Y') }}</td></tr>
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
