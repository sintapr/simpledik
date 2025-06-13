@extends('layouts.app')

@section('title', 'Laporan Semester')

@section('content')
<div class="row page-titles mx-0 align-items-center justify-content-between">
    <div class="col-auto">
        <h4 class="mb-0">@yield('title')</h4>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data @yield('title')</h4>

            {{-- Form Pencarian --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari semester atau tahun ajaran..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i> Cari</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Jumlah Siswa</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
@foreach ($kelasList as $item)
<tr>
    <td>{{ $item['jumlah_siswa'] }}</td>
    <td>{{ $item['semester'] }}</td>
    <td>
        @if($item['tahun_ajaran'])
            {{ $item['tahun_ajaran'] }}/{{ $item['tahun_ajaran'] + 1 }}
        @else
            -
        @endif
    </td>
    <td>
        <span class="badge {{ $item['status'] ? 'bg-success' : 'bg-secondary' }} text-white">
            {{ $item['status'] ? 'Aktif' : 'Tidak Aktif' }}
        </span>
    </td>
    <td>
        <a href="{{ route('laporan-semester.detail', ['id_kelas' => $item['kelas']->id_kelas, 'id_ta' => $item['id_ta']]) }}" class="btn btn-sm btn-info">
            <i class="fa fa-eye"></i> Detail
        </a>
    </td>
</tr>
@endforeach


                    </tbody>
                </table>
            </div>

           <p class="mt-2">
    Menampilkan {{ count($kelasList) }} data
</p>

        </div>
    </div>
</div>
@endsection
