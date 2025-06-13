@extends('layouts.app')
@section('title', $fase->exists ? 'Edit Fase' : 'Tambah Fase')

@section('content')
<div class="container">
    <h4 class="my-3">{{ $fase->exists ? 'Edit' : 'Tambah' }} Fase</h4>

    <form action="{{ $fase->exists ? route('fase.update', $fase->id_fase) : route('fase.store') }}" method="POST">
        @csrf
        @if($fase->exists)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>ID Fase</label>
            <input type="text" name="id_fase" value="{{ old('id_fase', $fase->id_fase) }}"
                   class="form-control @error('id_fase') is-invalid @enderror" readonly>
            @error('id_fase')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nama_fase" class="form-label">Nama Fase</label>
            <input type="text" name="nama_fase" class="form-control @error('nama_fase') is-invalid @enderror"
                value="{{ old('nama_fase', $fase->nama_fase) }}">
            @error('nama_fase') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">{{ $fase->exists ? 'Update' : 'Simpan' }}</button>
        <a href="{{ route('fase.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
