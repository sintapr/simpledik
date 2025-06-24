@extends('layouts.app')
@section('title', $monitoring->id_rapor ? 'Edit Monitoring' : 'Tambah Monitoring')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if($method === 'PUT') @method('PUT') @endif

                <div class="form-group">
                    <label>ID Rapor</label>
                    <input type="text" name="id_rapor" id="id_rapor" class="form-control @error('id_rapor') is-invalid @enderror"
                        value="{{ old('id_rapor', $monitoring->id_rapor) }}" readonly>
                </div>

                <div class="form-group">
                    <label>NIS</label>
                    <select name="NIS" id="NIS" class="form-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->NIS }}" {{ $s->NIS == $monitoring->NIS ? 'selected' : '' }}>
                                {{ $s->NIS }} - {{ $s->nama_siswa }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tahun Ajaran</label>
                    <select name="id_ta" id="id_ta" class="form-control" required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($tahun as $t)
                            <option value="{{ $t->id_ta }}"
                                data-semester="{{ $t->semester }}"
                                {{ $t->id_ta == $monitoring->id_ta ? 'selected' : '' }}>
                                {{ $t->tahun_ajaran }} - Semester {{ $t->semester }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Kelas</label>
                    <select name="id_kelas" class="form-control" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id_kelas }}" {{ $k->id_kelas == $monitoring->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>NIP</label>
                    <select name="NIP" class="form-control" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->NIP }}" {{ $g->NIP == $monitoring->NIP ? 'selected' : '' }}>
                                {{ $g->nama_guru }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Fase</label>
                    <select name="id_fase" class="form-control" required>
                        <option value="">-- Pilih Fase --</option>
                        @foreach($fase as $f)
                            <option value="{{ $f->id_fase }}" {{ $f->id_fase == $monitoring->id_fase ? 'selected' : '' }}>
                                {{ $f->nama_fase }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('monitoring.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateIdRapor() {
        const nis = $('#NIS').val();
        const semester = $('#id_ta option:selected').data('semester');

        if (!nis || !semester) return;

        $.ajax({
            url: '{{ route("monitoring.generateIdRapor") }}',
            method: 'GET',
            data: {
                nis: nis,
                semester: semester
            },
            success: function(response) {
                $('#id_rapor').val(response.id_rapor);
            },
            error: function(err) {
                console.error(err);
            }
        });
    }

    $('#NIS, #id_ta').on('change', updateIdRapor);
</script>
@endpush
