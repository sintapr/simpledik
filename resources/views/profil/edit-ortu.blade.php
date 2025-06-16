@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Profil Siswa</h3>

    <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- Informasi Siswa --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Informasi Siswa</div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama_siswa" class="form-control" value="{{ $user->nama_siswa }}">
                </div>

                <div class="form-group mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control" value="{{ $user->tgl_lahir->format('Y-m-d') }}">
                </div>

                <div class="form-group mb-3">
                    <label>Foto</label><br>
                    @if ($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto" height="100"
                            onerror="this.src='{{ asset('images/user/default.png') }}'">
                    @else
                        <em>Tidak ada foto</em>
                    @endif
                    <input type="file" name="foto" class="form-control mt-2">
                </div>
            </div>
        </div>

        {{-- Informasi Orangtua --}}
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">Informasi Orangtua</div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label>Nama Ayah</label>
                    <input type="text" name="nama_ayah" class="form-control" value="{{ $user->orangtua->nama_ayah ?? '' }}">
                </div>

                <div class="form-group mb-3">
                    <label>Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ $user->orangtua->pekerjaan_ayah ?? '' }}">
                </div>

                <div class="form-group mb-3">
                    <label>Nama Ibu</label>
                    <input type="text" name="nama_ibu" class="form-control" value="{{ $user->orangtua->nama_ibu ?? '' }}">
                </div>

                <div class="form-group mb-3">
                    <label>Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ $user->orangtua->pekerjaan_ibu ?? '' }}">
                </div>

                <div class="form-group mb-3">
                    <label>Alamat Orangtua</label>
                    <textarea name="alamat_orangtua" class="form-control" rows="2">{{ $user->orangtua->alamat ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('profil') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
