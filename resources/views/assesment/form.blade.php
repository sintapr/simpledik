@extends('layouts.app')
@section('title', isset($assesment) ? 'Edit Assesment' : 'Tambah Assesment')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($assesment) ? route('assesment.update', $assesment->id_assesment) : route('assesment.store') }}" method="POST">
                @csrf
                @if(isset($assesment)) @method('PUT') @endif

                <div class="form-group">
                    <label>ID Assesment</label>
                    <input type="text" name="id_assesment" class="form-control" 
                        value="{{ isset($assesment) ? $assesment->id_assesment : $newId }}" 
                        readonly>
                </div>
                
                <div class="form-group">
                    <label>NIS</label>
                    <select name="NIS" class="form-control">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->NIS }}" {{ old('NIS', $assesment->NIS ?? '') == $s->NIS ? 'selected' : '' }}>{{ $s->nama_siswa }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tujuan Pembelajaran</label>
                    <select name="id_tp" class="form-control">
                        <option value="">-- Pilih Tujuan Belajar --</option>

                        @foreach($tp as $t)
                            <option value="{{ $t->id_tp }}" {{ old('id_tp', $assesment->id_tp ?? '') == $t->id_tp ? 'selected' : '' }}>{{ $t->tujuan_pembelajaran }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Sudah Muncul</label>
                    <select name="sudah_muncul" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('sudah_muncul', $assesment->sudah_muncul ?? '') == 1 ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('sudah_muncul', $assesment->sudah_muncul ?? '') == 0 ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                 <div class="form-group">
                    <label>Konteks</label>
                    <input type="text" name="konteks" class="form-control" value="{{ old('konteks', $assesment->konteks ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Tempat dan Waktu</label>
                    <input type="text" name="tempat_waktu" class="form-control" value="{{ old('tempat_waktu', $assesment->tempat_waktu ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Kejadian Teramati</label>
                    <textarea name="kejadian_teramati" class="form-control">{{ old('kejadian_teramati', $assesment->kejadian_teramati ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Minggu</label>
                    <input type="text" name="minggu" class="form-control" value="{{ old('minggu', $assesment->minggu ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Bulan</label>
                    <input type="text" name="bulan" class="form-control" value="{{ old('bulan', $assesment->bulan ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $assesment->tahun ?? '') }}">
                </div>

                <div class="form-group">
                <label>Semester</label>
                <select name="semester" class="form-control">
                    <option value="">-- Pilih Semester --</option>
                    <option value="1" {{ old('semester', $assesment->semester ?? '') == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ old('semester', $assesment->semester ?? '') == '2' ? 'selected' : '' }}>2</option>
                </select>
                </div>


                <button class="btn btn-success mt-3">Simpan</button>
                <a href="{{ route('assesment.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
