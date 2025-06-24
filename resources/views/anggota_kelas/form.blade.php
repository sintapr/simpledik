@extends('layouts.app')
{{-- @section('title', 'Input Siswa ke Kelas') --}}

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between mb-3">
    <div class="col-auto">
        <h4 class="mb-0">@yield('title')</h4>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('anggota_kelas.index') }}">Manajemen Anggota Kelas</a></li>
            <li class="breadcrumb-item active">Input Siswa</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">Formulir Tambah Siswa ke Kelas</h5>

            <form method="POST" action="{{ route('anggota_kelas.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="id_wakel" class="form-label">Pilih Wali Kelas</label>
                    <select name="id_wakel" id="id_wakel" class="form-select" required>
                        <option value="">-- Pilih Wali Kelas --</option>
                        @foreach ($waliKelasList as $wk)
                            <option value="{{ $wk->id_wakel }}">
                                {{ $wk->guru->nama_guru }} - Kelas {{ $wk->kelas->nama_kelas }} ({{ $wk->tahunAjaran->tahun_mulai }} - Semester {{ ucfirst($wk->tahunAjaran->semester) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="40"><input type="checkbox" onclick="toggleAll(this)"></th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswaList as $siswa)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->NIS }}">
                                    </td>
                                    <td>{{ $siswa->NIS }}</td>
                                    <td>{{ $siswa->nama_siswa }}</td>
                                    <td>
                                        @php
                                            $sebelumnya = $anggotaSebelumnya[$siswa->NIS][0] ?? null;
                                        @endphp
                                        {{ $sebelumnya ? 'Kelas ' . $sebelumnya->waliKelas->kelas->nama_kelas : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('anggota_kelas.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script: Checkbox semua --}}
<script>
    function toggleAll(source) {
        const checkboxes = document.querySelectorAll('input[name="siswa_ids[]"]');
        checkboxes.forEach(cb => cb.checked = source.checked);
    }
</script>
@endsection
