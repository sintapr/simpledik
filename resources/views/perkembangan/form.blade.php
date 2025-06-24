@extends('layouts.app')
@section('title', $perkembangan->exists ? 'Edit Perkembangan' : 'Tambah Perkembangan')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('perkembangan.index') }}">Perkembangan</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $perkembangan->exists ? 'Edit' : 'Tambah' }} Perkembangan</h4>
                        <div class="basic-form">
                            <form method="POST" action="{{ $perkembangan->exists ? route('perkembangan.update', $perkembangan->id_perkembangan) : route('perkembangan.store') }}">
                                @csrf
                                @if ($perkembangan->exists)
                                    @method('PUT')
                                @endif

                                <div class="mb-3">
                                    <label for="id_perkembangan">ID Perkembangan</label>
                                    <input type="text" name="id_perkembangan" id="id_perkembangan"
                                        class="form-control @error('id_perkembangan') is-invalid @enderror"
                                        value="{{ old('id_perkembangan', $perkembangan->id_perkembangan) }}"
                                        {{ $perkembangan->exists ? 'readonly' : '' }}>
                                    @error('id_perkembangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="indikator">Indikator</label>
                                    <input type="text" name="indikator" id="indikator"
                                        class="form-control @error('indikator') is-invalid @enderror"
                                        value="{{ old('indikator', $perkembangan->indikator) }}">
                                    @error('indikator')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success">{{ $perkembangan->exists ? 'Update' : 'Simpan' }}</button>
                                <a href="{{ route('perkembangan.index') }}" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
