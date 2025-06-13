@extends('layouts.app')
@section('Wali Kelas')
@section('content')
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-body">
                <h4>{{ $isEdit ? 'Edit' : 'Tambah' }} Wali Kelas</h4>
                <form action="{{ $isEdit ? route('wali_kelas.update', $waliKelas->id_wakel) : route('wali_kelas.store') }}"
                    method="POST">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    {{-- @if (!$isEdit) --}}
                        <div class="mb-3">
                            <label for="id_wakel" class="form-label">ID Wali Kelas</label>
                            <input type="text" name="id_wakel" class="form-control @error('id_wakel') is-invalid @enderror"
                            value="{{ old('id_wakel', !$isEdit ? $nextId : $waliKelas->id_wakel) }}" readonly>
                        
                            @error('id_wakel')
                                {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                            @enderror
                        </div>
                    {{-- @endif --}}

                    <div class="mb-3">
                        <label for="NIP" class="form-label">Nama Guru</label>
                        <select name="NIP" class="form-control @error('NIP') is-invalid @enderror">
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($guru as $g)
                                <option value="{{ $g->NIP }}"
                                    {{ old('NIP', $waliKelas->NIP) == $g->NIP ? 'selected' : '' }}>{{ $g->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                        @error('NIP')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_kelas" class="form-label">Nama Kelas</label>
                        <select name="id_kelas" class="form-control @error('id_kelas') is-invalid @enderror">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id_kelas }}"
                                    {{ old('id_kelas', $waliKelas->id_kelas) == $k->id_kelas ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }} </option>
                            @endforeach
                        </select>
                        @error('id_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_ta" class="form-label">Tahun Ajaran</label>
                        <select name="id_ta" class="form-control @error('id_ta') is-invalid @enderror">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach ($tahunAjaran as $ta)
                                <option value="{{ $ta->id_ta }}"
                                    {{ old('id_ta', $waliKelas->id_ta) == $ta->id_ta ? 'selected' : '' }}>
                                    {{ $ta->tahun_ajaran }} | {{ $ta->semester_text }} {{ $ta->status ? '(Aktif)' : '' }}</option>
                            @endforeach
                        </select>
                        @error('id_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('wali_kelas.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
