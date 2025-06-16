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
        $role = strtolower($user->jabatan); // admin, wali_kelas, dll
    }

    if ($role) {
        $notifikasi = \App\Models\Notifikasi::where('untuk_role', $role)
            ->when($nis, function($query) use ($nis) {
                $query->where(function($q) use ($nis) {
                    $q->whereNull('NIS')->orWhere('NIS', $nis);
                });
            })
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $unreadCount = $notifikasi->where('dibaca', false)->count();
    } else {
        $notifikasi = collect();
        $unreadCount = 0;
    }
@endphp

<li class="nav-item position-relative" id="customNotif">
    <a class="nav-link position-relative" href="#" onclick="toggleNotifDropdown(event)">
        <i class="bi bi-bell"></i>
        @if($unreadCount > 0)
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                {{ $unreadCount }}
            </span>
        @endif
    </a>

    <div id="notifDropdown" class="custom-dropdown shadow">
        @forelse($notifikasi as $notif)
            @php
                $isMingguan = str_contains(strtolower($notif->judul), 'mingguan');
                $icon = $isMingguan ? 'calendar-week' : 'file-earmark-text';
                $iconColor = $isMingguan ? 'text-success' : 'text-primary';
            @endphp

            <div class="notif-item {{ $notif->dibaca ? '' : 'fw-bold bg-light' }}">
                <div class="d-flex align-items-start">
                    <i class="bi bi-{{ $icon }} me-2 fs-4 {{ $iconColor }}"></i>
                    <div class="flex-grow-1">
                        <div class="notif-title mb-1">{{ $notif->judul }}</div>
                        <div class="notif-body text-muted small">{{ Str::limit($notif->pesan, 90) }}</div>
                        <div class="notif-time text-muted fst-italic small mt-1">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
            @if(!$loop->last)
                <hr class="my-2">
            @endif
        @empty
            <div class="text-muted text-center small py-2">Tidak ada notifikasi</div>
        @endforelse
    </div>
</li>

<script>
function toggleNotifDropdown(event) {
    event.preventDefault();
    const dropdown = document.getElementById('notifDropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';

    document.addEventListener('click', function handler(e) {
        if (!document.getElementById('customNotif').contains(e.target)) {
            dropdown.style.display = 'none';
            document.removeEventListener('click', handler);
        }
    });
}
</script>




