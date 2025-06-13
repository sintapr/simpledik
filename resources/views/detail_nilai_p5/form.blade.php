@extends('layouts.app')
@section('title', $item->id_detail_nilai_p5 ? 'Edit Nilai P5' : 'Tambah Nilai P5')
@section('content')

<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-body">
            {{-- Form tambah/edit --}}
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($method === 'PUT') @method('PUT') @endif

                {{-- ID Detail Nilai P5 --}}
                <div class="form-group">
                    <label>ID Detail Nilai P5</label>
                    <input type="text" name="id_detail_nilai_p5" class="form-control" 
                        value="{{ old('id_detail_nilai_p5', $item->id_detail_nilai_p5) }}" readonly>
                </div>

                {{-- Rapor --}}
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

                {{-- Perkembangan --}}
                <div class="form-group">
                    <label>Aspek Perkembangan</label>
                    <select name="id_perkembangan" class="form-control" required>
                        <option value="">-- Pilih Perkembangan --</option>
                        @foreach($perkembangan as $p)
                            <option value="{{ $p->id_perkembangan }}" {{ old('id_perkembangan', $item->id_perkembangan) == $p->id_perkembangan ? 'selected' : '' }}>
                                {{ $p->indikator }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nilai --}}
                <div class="form-group">
                    <label>Nilai</label>
                    <input type="text" name="nilai" class="form-control" value="{{ old('nilai', $item->nilai) }}" required>
                </div>

                {{-- Upload Foto --}}
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control-file">
                    @if($item->foto)
                        <div class="mt-2">
                            <strong>Foto Saat Ini:</strong><br>
                            <img src="{{ asset('storage/foto_nilai_p5/' . $item->foto) }}" width="100" alt="Foto">
                        </div>
                    @endif
                </div>

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('detail_nilai_p5.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

@endsection
