@extends('layouts.app')

@section('title', $materi->exists ? 'Edit Materi Tarbiyah' : 'Tambah Materi Tarbiyah')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="{{ $materi->exists ? route('materi_tarbiyah.update', $materi->id_materi) : route('materi_tarbiyah.store') }}" method="POST">
                @csrf
                @if($materi->exists)
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label>ID Materi</label>
                    <input type="text" name="id_materi" class="form-control" value="{{ old('id_materi', $materi->id_materi) }}" {{ $materi->exists ? 'readonly' : '' }}>
                </div>

                <div class="form-group">
                    <label>Materi</label>
                    <input type="text" name="materi" class="form-control" value="{{ old('materi', $materi->materi) }}">
                </div>

                <div class="form-group">
                    <label>Indikator</label>
                    <select name="id_indikator" class="form-control">
                        <option value="">Pilih Indikator</option>
                        @foreach($indikator as $i)
                            <option value="{{ $i->id_indikator }}" {{ old('id_indikator', $materi->id_indikator) == $i->id_indikator ? 'selected' : '' }}>
                                {{ $i->indikator }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Semester</label>
                    <input type="text" name="semester" class="form-control" value="{{ old('semester', $materi->semester) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="aktif" value="1"
                                {{ old('status', $materi->status ?? 1) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="aktif">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="tidakaktif" value="0"
                                {{ old('status', $materi->status ?? 1) == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidakaktif">Tidak Aktif</label>
                        </div>
                    </div>
                    @error('status')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                

                <button type="submit" class="btn btn-primary">{{ $materi->exists ? 'Update' : 'Simpan' }}</button>
                <a href="{{ route('materi_tarbiyah.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
