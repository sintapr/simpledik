@extends('layouts.app')
@section('title', $penilaian->id_penilaian_cp ? 'Edit Penilaian CP' : 'Tambah Penilaian CP')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if($method === 'PUT') @method('PUT') @endif

                <div class="mb-3">
                    <label for="id_penilaian_cp" class="form-label">ID Penilaian CP</label>
                    <input type="text" name="id_penilaian_cp" class="form-control" 
                           value="{{ old('id_penilaian_cp', $penilaian->id_penilaian_cp) }}" readonly>
                </div>
                

                <div class="form-group">
                    <label>Perkembangan</label>
                    <select name="id_perkembangan" class="form-control" required>
                        <option value="">-- Pilih Perkembangan --</option>
                        @foreach($perkembangan as $p)
                            <option value="{{ $p->id_perkembangan }}"  {{ old('id_perkembangan', $indikator->id_perkembangan ?? '') == $p->id_perkembangan ? 'selected' : '' }}>
                                {{ $p->indikator }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Aspek Nilai</label>
                    <textarea name="aspek_nilai" class="form-control" required>{{ old('aspek_nilai', $penilaian->aspek_nilai) }}</textarea>
                </div>

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('penilaian_cp.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

@endsection
