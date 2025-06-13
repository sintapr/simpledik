@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Profil Guru</h3>

    <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama_guru" class="form-control" value="{{ $user->nama_guru }}">
        </div>

        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="form-control" value="{{ $user->tgl_lahir->format('Y-m-d') }}">
        </div>

        <div class="form-group">
            <label>Foto</label><br>
            @if ($user->foto)
                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto" height="100"
                onerror="this.src='{{ asset('images/user/default.png') }}'">
            @else
    <em>Tidak ada foto</em>
@endif

            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('profil') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
