@extends('layouts.app')
@section('title', isset($absensi) ? 'Edit Absensi' : 'Tambah Absensi')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($absensi) ? route('absensi.update', $absensi->id_absensi) : route('absensi.store') }}" method="POST">
                @csrf
                @if(isset($absensi)) @method('PUT') @endif

                <div class="form-group">
                    <label>ID Absensi</label>
                    <input type="text" name="id_absensi" class="form-control" 
                        value="{{ old('id_absensi', $absensi->id_absensi ?? $newId ?? '') }}" readonly>
                </div>
                

                <div class="form-group">
                    <label for="NIS">Siswa</label>
                    <select name="NIS" class="form-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->NIS }}" {{ old('NIS', $absensi->NIS ?? '') == $s->NIS ? 'selected' : '' }}>{{ $s->nama_siswa }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_kelas">Kelas</label>
                    <select name="id_kelas" class="form-control" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas', $absensi->id_kelas ?? '') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $absensi->tanggal ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="STATUS">Status</label>
                    <select name="STATUS" class="form-control" required>
                        @foreach(['Hadir', 'Sakit', 'Izin', 'Alpa'] as $status)
                            <option value="{{ $status }}" {{ old('STATUS', $absensi->STATUS ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_ta">Tahun Ajaran</label>
                    <select name="id_ta" class="form-control" required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($tahun as $t)
                            <option value="{{ $t->id_ta }}" {{ old('id_ta', $absensi->id_ta ?? '') == $t->id_ta ? 'selected' : '' }}>{{ $t->tahun }} ({{ $t->semester }})</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
