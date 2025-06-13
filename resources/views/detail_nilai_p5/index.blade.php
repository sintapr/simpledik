@extends('layouts.app')
@section('title', 'Detail Nilai P5')
@section('content')

<div class="row page-titles mx-0 justify-content-between align-items-center">
    <div class="col-auto">
        <a href="{{ route('detail_nilai_p5.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
    </div>
    <div class="col-auto">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
        </ol>
    </div>
</div>

<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">@yield('title')</h4>

            {{-- Search --}}
            <form method="GET" class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari ID Rapor atau Aspek Perkembangan..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID Rapor</th>
                            <th>Aspek Perkembangan</th>
                            <th>Nilai</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{ $item->id_detail_nilai_p5 }}</td>
                                <td>{{ $item->rapor->id_rapor ?? '-' }}</td>
                                <td>{{ $item->perkembangan->indikator ?? $item->id_perkembangan }}</td>
                                <td>{{ $item->nilai }}</td>
                                <td>
                                    @if($item->foto)
                                        <a href="{{ asset('storage/foto_nilai_p5/' . $item->foto) }}" target="_blank">
                                            <img src="{{ asset('storage/foto_nilai_p5/' . $item->foto) }}" alt="Foto" width="60">
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('detail_nilai_p5.edit', $item->id_detail_nilai_p5) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('detail_nilai_p5.destroy', $item->id_detail_nilai_p5) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Keterangan jumlah --}}
            <p class="mt-2">Menampilkan {{ $data->count() }} dari total {{ $data->total() }} data</p>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@endsection
