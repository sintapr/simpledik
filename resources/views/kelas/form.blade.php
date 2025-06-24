@extends('layouts.app')
@section('title', isset($kelas->id_kelas) ? 'Edit Kelas' : 'Tambah Kelas')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <a href="{{ route('kelas.index') }}" class="btn btn-secondary mb-3">
        </a>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4>{{ isset($kelas->id_kelas) ? 'Edit Kelas' : 'Tambah Kelas' }}</h4>

            <form action="{{ isset($kelas->id_kelas) ? route('kelas.update', $kelas->id_kelas) : route('kelas.store') }}" method="POST">
                @csrf
                @if(isset($kelas->id_kelas))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="id_kelas" class="form-label">ID Kelas</label>
                    <input type="text" name="id_kelas" class="form-control" id="id_kelas"
                        value="{{ old('id_kelas', $kelas->id_kelas ?? $newId ?? '') }}" {{ isset($kelas->id_kelas) ? 'readonly' : '' }}>
                    @error('id_kelas') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_kelas" class="form-label">Nama Kelas</label>
                    <input type="text" name="nama_kelas" class="form-control" id="nama_kelas"
                        value="{{ old('nama_kelas', $kelas->nama_kelas) }}">
                    @error('nama_kelas') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    {{ isset($kelas->id_kelas) ? 'Update' : 'Simpan' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
