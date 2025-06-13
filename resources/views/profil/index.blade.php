@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profil {{ strtoupper($role) }}</h2>

    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if($role === 'ortu')
            <div class="form-group">
                <label>Nama Siswa</label>
                <input type="text" name="nama_siswa" class="form-control" value="{{ $user->nama_siswa }}">
            </div>
        @else
            <div class="form-group">
                <label>Nama Guru</label>
                <input type="text" name="nama_guru" class="form-control" value="{{ $user->nama_guru }}">
            </div>
        @endif

        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="form-control" value="{{ $user->tgl_lahir }}">
        </div>

        <div class="form-group">
            <label>Foto</label><br>
            @if($user->foto)
                <img src="{{ asset('storage/foto/' . $user->foto) }}" width="100" class="mb-2">
            @endif
            <input type="file" name="foto" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
