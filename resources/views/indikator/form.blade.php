@extends('layouts.app')

@section('title', $indikator->exists ? 'Edit Indikator Tarbiyah' : 'Tambah Indikator Tarbiyah')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="{{ $indikator->exists ? route('indikator.update', $indikator->id_indikator) : route('indikator.store') }}" method="POST">
                @csrf
                @if($indikator->exists)
                    @method('PUT')
                @endif

                @if ($indikator->exists)
                    <div class="form-group mb-3">
                        <label for="id_indikator">ID Indikator</label>
                        <input type="text" name="id_indikator" class="form-control" 
                               value="{{ old('id_indikator', $indikator->id_indikator) }}" readonly>
                    </div>
                @else
                    <div class="alert alert-info">
                        ID Indikator akan dibuat otomatis berdasarkan semester.
                    </div>
                @endif

                <div class="form-group mb-3">
                    <label for="indikator">Indikator</label>
                    <input type="text" name="indikator" class="form-control @error('indikator') is-invalid @enderror" 
                           value="{{ old('indikator', $indikator->indikator) }}">
                    @error('indikator')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="id_perkembangan">Perkembangan</label>
                    <select name="id_perkembangan" class="form-control @error('id_perkembangan') is-invalid @enderror">
                        <option value="">Pilih Perkembangan</option>
                        @foreach($perkembangan as $p)
                            <option value="{{ $p->id_perkembangan }}"  {{ old('id_perkembangan', $indikator->id_perkembangan ?? '') == $p->id_perkembangan ? 'selected' : '' }}>
                                {{ $p->indikator }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_perkembangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="semester">Semester</label>
                    <input type="text" name="semester" class="form-control @error('semester') is-invalid @enderror" 
                           value="{{ old('semester', $indikator->semester) }}">
                    @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="aktif" value="1"
                                {{ old('status', $indikator->status ?? 1) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="aktif">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="tidakaktif" value="0"
                                {{ old('status', $indikator->status ?? 1) == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidakaktif">Tidak Aktif</label>
                        </div>
                    </div>
                    @error('status')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                

                <button type="submit" class="btn btn-primary">
                    {{ $indikator->exists ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('indikator.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
