@extends('layouts.app')
@section('title', $suratHafalan->exists ? 'Edit Surat Hafalan' : 'Tambah Surat Hafalan')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('surat-hafalan.index') }}">Surat Hafalan</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $suratHafalan->exists ? 'Edit' : 'Tambah' }} Surat Hafalan</h4>
                        <div class="basic-form">
                            <form method="POST" action="{{ $suratHafalan->exists ? route('surat-hafalan.update', $suratHafalan->id_surat) : route('surat-hafalan.store') }}">
                                @csrf
                                @if ($suratHafalan->exists)
                                    @method('PUT')
                                @endif

                                {{-- ID Surat (readonly) --}}
                                <div class="form-group">
                                    <label for="id_surat">ID Surat Hafalan</label>
                                    <input type="text" name="id_surat" class="form-control" 
                                        value="{{ old('id_surat', $item->id_surat) }}" readonly>
                                </div>

                                {{-- Nama Surat --}}
                                <div class="form-group">
                                    <label for="nama_surat">Nama Surat</label>
                                    <input type="text" name="nama_surat" class="form-control"
                                        value="{{ old('nama_surat', $item->nama_surat) }}" required>
                                </div>

                                {{-- Perkembangan --}}
                                {{-- <div class="form-group">
                                    <label for="id_perkembangan">Indikator Perkembangan</label>
                                    <select name="id_perkembangan" class="form-control" required>
                                        <option value="">-- Pilih Indikator --</option>
                                        @foreach($perkembangan as $p)
                                            <option value="{{ $p->id_perkembangan }}"
                                                {{ old('id_perkembangan', $item->id_perkembangan) == $p->id_perkembangan ? 'selected' : '' }}>
                                                {{ $p->indikator }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}


                                <div class="mb-3">
                                    <label>Perkembangan</label>
                                    <select name="id_perkembangan" class="form-control @error('id_perkembangan') is-invalid @enderror" required>
                                        <option value="">Pilih Perkembangan</option>
                                        @foreach ($perkembangan as $item)
                                            <option value="{{ $item->id_perkembangan }}" 
                                                {{ old('id_perkembangan', $suratHafalan->id_perkembangan) == $item->id_perkembangan ? 'selected' : '' }}>
                                                {{ $item->indikator }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_perkembangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success">{{ $suratHafalan->exists ? 'Update' : 'Simpan' }}</button>
                                <a href="{{ route('surat-hafalan.index') }}" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
