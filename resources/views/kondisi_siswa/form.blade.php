@extends('layouts.app')
@section('title', isset($data) ? 'Edit Kondisi Siswa' : 'Tambah Kondisi Siswa')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($data) ? route('kondisi-siswa.update', $data->id_kondisi) : route('kondisi-siswa.store') }}" method="POST">
                    @csrf
                    @if (isset($data))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label>ID Kondisi</label>
                        <input type="text" name="id_kondisi" class="form-control" value="{{ old('id_kondisi', $data->id_kondisi ?? '') }}" readonly>
                    </div>                    

                    <div class="form-group">
                        <label>NIS</label>
                        <select name="NIS" class="form-control" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach ($siswa as $s)
                                <option value="{{ $s->NIS }}" {{ (isset($data) && $data->NIS == $s->NIS) ? 'selected' : '' }}>{{ $s->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group"><label>BB</label><input type="number" name="BB" class="form-control" value="{{ old('BB', $data->BB ?? '') }}"></div>
                    <div class="form-group"><label>TB</label><input type="number" name="TB" class="form-control" value="{{ old('TB', $data->TB ?? '') }}"></div>
                    <div class="form-group"><label>LK</label><input type="number" name="LK" class="form-control" value="{{ old('LK', $data->LK ?? '') }}"></div>

                    <div class="form-group">
                        <label>Penglihatan</label>
                        <select name="penglihatan" class="form-control" required>
                            <option value="Normal" {{ old('penglihatan', $data->penglihatan ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Tidak Normal" {{ old('penglihatan', $data->penglihatan ?? '') == 'Tidak Normal' ? 'selected' : '' }}>Tidak Normal</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pendengaran</label>
                        <select name="pendengaran" class="form-control" required>
                            <option value="Normal" {{ old('pendengaran', $data->pendengaran ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Tidak Normal" {{ old('pendengaran', $data->pendengaran ?? '') == 'Tidak Normal' ? 'selected' : '' }}>Tidak Normal</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Gigi</label>
                        <select name="gigi" class="form-control" required>
                            <option value="Normal" {{ old('gigi', $data->gigi ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Tidak Normal" {{ old('gigi', $data->gigi ?? '') == 'Tidak Normal' ? 'selected' : '' }}>Tidak Normal</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <select name="id_ta" class="form-control" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach ($tahun as $t)
                                <option value="{{ $t->id_ta }}" {{ (isset($data) && $data->id_ta == $t->id_ta) ? 'selected' : '' }}>{{ $t->tahun_mulai }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">{{ isset($data) ? 'Update' : 'Simpan' }}</button>
                    <a href="{{ route('kondisi-siswa.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
