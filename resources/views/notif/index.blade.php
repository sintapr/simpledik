@extends('layouts.app')
@section('title', 'Notifikasi')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Semua Notifikasi</h4>
        <form method="POST" action="{{ route('notifikasi.readAll') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary">Tandai Semua Dibaca</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="list-group">
        @forelse($notifikasi as $notif)
            <div class="list-group-item {{ $notif->dibaca ? '' : 'fw-bold bg-light' }}">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div>{{ $notif->judul }}</div>
                        <div class="text-muted small">{{ $notif->pesan }}</div>
                        <div class="text-muted small fst-italic">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                    @if(!$notif->dibaca)
                        <form method="POST" action="/notifikasi/{{ $notif->id }}/read">
                            @csrf
                            <button class="btn btn-sm btn-outline-success">✓</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted">Tidak ada notifikasi.</p>
        @endforelse
    </div>
</div>
@endsection
