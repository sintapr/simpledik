@extends('layouts.app')
@section('title', $item->id_detail_nilai_tarbiyah ? 'Edit Nilai Tarbiyah' : 'Tambah Nilai Tarbiyah')
@section('content')

<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-body">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if($method === 'PUT') @method('PUT') @endif

                <div class="form-group">
                    <label>ID Detail Nilai Tarbiyah</label>
                    <input type="text" name="id_detail_nilai_tarbiyah" class="form-control @error('id_detail_nilai_tarbiyah') is-invalid @enderror"
                        value="{{ old('id_detail_nilai_tarbiyah', $item->id_detail_nilai_tarbiyah) }}" 
                        readonly>
                    @error('id_detail_nilai_tarbiyah')
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
                    <label>Materi Tarbiyah</label>
                    <select name="id_materi" class="form-control" required>
                        <option value="">-- Pilih Materi --</option>
                        @foreach($materi as $m)
                            <option value="{{ $m->id_materi }}" {{ old('id_materi', $item->id_materi) == $m->id_materi ? 'selected' : '' }}>
                                {{ $m->materi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nilai</label>
                    <select name="nilai" class="form-control" required>
                        <option value="">-- Pilih Nilai --</option>
                        @foreach($nilai_options as $val)
                            <option value="{{ $val }}" {{ old('nilai', $item->nilai) == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('detail_nilai_tarbiyah.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

@endsection
