@extends('layouts.app')
@section('title', $orangtua->exists ? 'Edit Orang Tua' : 'Tambah Orang Tua')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-body">
                <h4>{{ $orangtua->exists ? 'Edit' : 'Tambah' }} Data Orang Tua</h4>
                <form method="POST" action="{{ $orangtua->exists ? route('orangtua.update', $orangtua->id_ortu) : route('orangtua.store') }}">
                    @csrf
                    @if($orangtua->exists) @method('PUT') @endif

                    <div class="mb-3">
                        <label>ID Orang Tua</label>
                        <input type="text" name="id_ortu" value="{{ old('id_ortu', $orangtua->id_ortu) }}"
                               class="form-control @error('id_ortu') is-invalid @enderror" readonly>
                        @error('id_ortu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <div class="mb-3">
                        <label>NIS</label>
                        <input type="text" name="NIS" class="form-control @error('NIS') is-invalid @enderror"
                            value="{{ old('NIS', $orangtua->NIS) }}">
                        @error('NIS')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label>Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror"
                            value="{{ old('nama_ayah', $orangtua->nama_ayah) }}">
                        @error('nama_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label>Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror"
                            value="{{ old('nama_ibu', $orangtua->nama_ibu) }}">
                        @error('nama_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label>Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                            value="{{ old('pekerjaan_ayah', $orangtua->pekerjaan_ayah) }}">
                        @error('pekerjaan_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label>Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                            value="{{ old('pekerjaan_ibu', $orangtua->pekerjaan_ibu) }}">
                        @error('pekerjaan_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $orangtua->alamat) }}</textarea>
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button class="btn btn-primary">{{ $orangtua->exists ? 'Update' : 'Simpan' }}</button>
                    <a href="{{ route('orangtua.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
