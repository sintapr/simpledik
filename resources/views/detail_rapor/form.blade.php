@extends('layouts.app')
@section('title', $detail->no_detail_rapor ? 'Edit Detail Rapor' : 'Tambah Detail Rapor')
@section('content')

<div class="container-fluid">
    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if($method === 'PUT') @method('PUT') @endif

                <div class="mb-3">
                    <label for="no_detail_rapor" class="form-label">No Detail Rapor</label>
                    <input type="text" name="no_detail_rapor" class="form-control" 
                           value="{{ old('no_detail_rapor', $detail->no_detail_rapor) }}" readonly>
                </div>
                

                <div class="form-group">
                    <label>Pilih Rapor</label>
                    <select name="id_rapor" class="form-control" required>
                        <option value="">-- Pilih Rapor --</option>
                        @foreach($rapor as $r)
                            <option value="{{ $r->id_rapor }}" {{ old('id_rapor', $detail->id_rapor) == $r->id_rapor ? 'selected' : '' }}>
                                {{ $r->id_rapor }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Indikator Perkembangan</label>
                    <select name="id_perkembangan" class="form-control" required>
                        <option value="">-- Pilih Perkembangan --</option>
                        @foreach($perkembangan as $p)
                            <option value="{{ $p->id_perkembangan }}" {{ old('id_perkembangan', $detail->id_perkembangan) == $p->id_perkembangan ? 'selected' : '' }}>
                                {{ $p->indikator }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('detail_rapor.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

@endsection
