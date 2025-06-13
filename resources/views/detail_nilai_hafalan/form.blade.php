@extends('layouts.app')
@section('title', $item->id_detail_nilai_hafalan ? 'Edit Nilai Hafalan' : 'Tambah Nilai Hafalan')
@section('content')

<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-body">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if($method === 'PUT') @method('PUT') @endif

                <div class="form-group">
                    <label>ID Detail Nilai Hafalan</label>
                    <input type="text" name="id_detail_nilai_hafalan" class="form-control @error('id_detail_nilai_hafalan') is-invalid @enderror"
                        value="{{ old('id_detail_nilai_hafalan', $item->id_detail_nilai_hafalan) }}" readonly>
                    @error('id_detail_nilai_hafalan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                

                <div class="form-group">
                    <label>Id Rapor</label>
                    <select name="id_rapor" class="form-control" required>
                        <option value="">-- Pilih Rapor --</option>
                        @foreach($rapor as $r)
                            <option value="{{ $r->id_rapor }}" {{ old('id_rapor', $item->id_rapor) == $r->id_rapor ? 'selected' : '' }}>
                                {{ $r->id_rapor }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Surat</label>
                    <select name="id_surat" class="form-control" required>
                        <option value="">-- Pilih Surat --</option>
                        @foreach($surat as $s)
                            <option value="{{ $s->id_surat }}" {{ old('id_surat', $item->id_surat) == $s->id_surat ? 'selected' : '' }}>
                                {{ $s->nama_surat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nilai</label>
                    <select name="nilai" class="form-control" required>
                        <option value="">-- Pilih Nilai --</option>
                        @foreach($nilai_options as $val)
                            <option value="{{ $val }}" {{ old('nilai', $item->nilai) == $val ? 'selected' : '' }}>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('detail_nilai_hafalan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

@endsection
