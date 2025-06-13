@extends('layouts.app')
@section('title', 'Manajemen Anggota Kelas')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <a href="{{ route('anggota_kelas.create') }}" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Input Siswa ke Kelas
        </a>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('anggota_kelas.index') }}">@yield('title')</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4">@yield('title')</h4>

            <form method="GET" action="{{ route('anggota_kelas.index') }}" class="mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="id_ta" class="form-label">Filter Tahun Ajaran</label>
                        <select name="id_ta" id="id_ta" class="form-control" onchange="this.form.submit()">
                            @foreach ($tahunAjaranList as $ta)
                                <option value="{{ $ta->id_ta }}" {{ $id_ta == $ta->id_ta ? 'selected' : '' }}>
                                    {{ $ta->tahun_mulai }} - Semester {{ ucfirst($ta->semester) }}
                                    {{ $ta->status ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari Nama Siswa</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Nama siswa..."
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Tahun Ajaran</th>
                            <th>Wali Kelas</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($anggotaKelas as $item)
                            <tr>
                                <td>{{ $item->siswa->NIS }}</td>
                                <td>{{ $item->siswa->nama_siswa }}</td>
                                <td>
                                    <span class="badge bg-info text-white">
                                        {{ $item->waliKelas->tahunAjaran->tahun_mulai }} - Semester {{ ucfirst($item->waliKelas->tahunAjaran->semester) }}
                                    </span>
                                </td>
                                <td>{{ $item->waliKelas->guru->nama_guru ?? '-' }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('anggota_kelas.destroy', $item->id_anggota) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus siswa dari kelas ini?')"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada anggota kelas untuk tahun ajaran ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <p class="mt-3 text-muted">
                Menampilkan {{ $anggotaKelas->count() }} dari {{ $anggotaKelas->total() }} data anggota kelas.
            </p>

            <div class="d-flex justify-content-center">
                {{ $anggotaKelas->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
