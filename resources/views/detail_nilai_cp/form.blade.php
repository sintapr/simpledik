@extends('layouts.app')
@section('title', $item->id_detail_nilai_cp ? 'Edit Nilai CP' : 'Tambah Nilai CP')
@section('content')

<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-body">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($method === 'PUT') @method('PUT') @endif

                <div class="mb-3">
                    <label for="id_detail_nilai_cp" class="form-label">ID Detail Nilai CP</label>
                    <input type="text" name="id_detail_nilai_cp" class="form-control" 
                           value="{{ old('id_detail_nilai_cp', $item->id_detail_nilai_cp) }}" readonly>
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
                    <label>Penilaian CP</label>
                    <select name="id_penilaian_cp" class="form-control" required>
                        <option value="">-- Penilaian --</option>
                        @foreach($penilaian as $p)
                            <option value="{{ $p->id_penilaian_cp }}" {{ old('id_penilaian_cp', $item->id_penilaian_cp) == $p->id_penilaian_cp ? 'selected' : '' }}>
                                {{ $p->aspek_nilai }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nilai</label>
                    <input type="text" name="nilai" class="form-control" value="{{ old('nilai', $item->nilai) }}" required>
                </div>

                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control">
                    @if($item->foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" width="100">
                        </div>
                    @endif
                </div>

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('detail_nilai_cp.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

@endsection
