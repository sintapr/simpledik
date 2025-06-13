
<!--**********************************
    Nav header start
***********************************-->
<div class="nav-header">
    <div class="brand-logo">
        <a href="{{ route('dashboard') }}">
            <b class="logo-abbr"></b>
            <span class="logo-compact"></span>
            <span class="brand-title d-flex align-items-center">
                <img src="{{ asset('images/bgbro.png') }}" alt="Logo"
                     style="height: 45px; width: 45px; object-fit: contain; margin-right: 10px;">
                <span>SIMPELDIK</span>
            </span>
        </a>
    </div>
</div>
<!--**********************************
    Nav header end
***********************************-->

<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content clearfix">
        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
        </div>

        @php
            use Illuminate\Support\Facades\Route;
            use Illuminate\Support\Facades\Auth;

            $routeName = Route::currentRouteName();
            $role = null;
            $user = null;
            $userName = 'User';
            $photoPath = 'images/user/default.png'; // default

            if (Auth::guard('guru')->check()) {
                $user = Auth::guard('guru')->user();
                $role = strtolower($user->jabatan);
                $userName = $user->nama_guru ?? 'Guru';
                if ($user->foto) {
                    $photoPath = 'storage/' . $user->foto;
                }
            } elseif (Auth::guard('siswa')->check()) {
                $user = Auth::guard('siswa')->user();
                $role = 'ortu';
                $userName = $user->nama_siswa ?? 'Orang Tua';
                $photoPath = $user->foto ? 'storage/foto/' . $user->foto : $photoPath;
            }
        @endphp

        <div class="header-right d-flex align-items-center">
            <ul class="d-flex align-items-center list-inline mb-0">
                {{-- Notifikasi --}}
                <li class="icons dropdown">
                    @include('notif.notifikasi')
                </li>

                {{-- User Profile --}}
                <li class="icons dropdown ms-3">
                    <div class="user-img c-pointer position-relative" data-bs-toggle="dropdown">
                        <span class="activity active"></span>
                        <img src="{{ asset($photoPath) }}" height="40" width="40" alt="User" class="rounded-circle">
                    </div>
                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <div class="d-flex align-items-center p-3 border-bottom">
                                <img src="{{ asset($photoPath) }}" height="50" width="50" class="rounded-circle" alt="User">
                                <div>
                                    <h5 class="mb-0">{{ $userName }}</h5>
                                    <small class="text-muted">{{ strtoupper($role) }}</small>
                                </div>
                            </div>
                            <ul>
                                <li>
                                    <a href="{{ route('profil') }}" class="dropdown-item">
                                        <i class="icon-user"></i> <span>Profil</span>
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="icon-key"></i> <span>Logout</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--**********************************
    Header end
***********************************-->