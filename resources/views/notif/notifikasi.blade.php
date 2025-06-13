@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;

    $nis = null;
    $user = null;
    $role = null;

    if (Auth::guard('siswa')->check()) {
        $user = Auth::guard('siswa')->user();
        $role = 'orangtua';
        $nis = $user->NIS ?? null;
    } elseif (Auth::guard('guru')->check()) {
        $user = Auth::guard('guru')->user();
        $role = strtolower($user->jabatan); // misal: admin, wali_kelas
    } else {
        $role = null;
    }

    if ($role) {
        $notifikasi = \App\Models\Notifikasi::where('untuk_role', $role)
            ->when($nis, function($query) use ($nis) {
                $query->where(function($q) use ($nis) {
                    $q->whereNull('NIS')
                      ->orWhere('NIS', $nis);
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $unreadCount = $notifikasi->where('dibaca', false)->count();
    } else {
        $notifikasi = collect();
        $unreadCount = 0;
    }
@endphp

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell"></i>
        @if($unreadCount > 0)
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                {{ $unreadCount }}
            </span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end" style="width: 300px;">
        @if($notifikasi->isEmpty())
            <li class="dropdown-item text-center text-muted">Tidak ada notifikasi</li>
        @else
            @foreach($notifikasi as $notif)
                <li class="dropdown-item {{ $notif->dibaca ? '' : 'fw-bold' }}">
                    <div>
                        <strong>{{ $notif->judul }}</strong><br>
                        <small>{{ Str::limit($notif->pesan, 60) }}</small><br>
                        <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                    </div>
                </li>
                <li><hr class="dropdown-divider"></li>
            @endforeach
        @endif
    </ul>
</li>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.mark-as-read').forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                let notifId = this.dataset.id;

                fetch(`/notifikasi/${notifId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(() => {
                    location.reload();
                });
            });
        });
    });
</script>
@endsection

