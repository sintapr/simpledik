@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;

    $routeName = Route::currentRouteName();
    $role = null;

    // Cek apakah login sebagai guru
    if (Auth::guard('guru')->check()) {
        $user = Auth::guard('guru')->user();
        $role = strtolower($user->jabatan); // admin / kepala_sekolah / wali_kelas
    }
    // Cek apakah login sebagai siswa
    elseif (Auth::guard('siswa')->check()) {
        $user = Auth::guard('siswa')->user();
        $role = 'ortu';
    }
@endphp

<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu text-white" id="menu">
            <!-- DASHBOARD -->
            <li class="{{ $routeName === 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            {{-- AKADEMIK --}}
            @if (in_array($role, ['admin', 'wali_kelas', 'kepala_sekolah', 'guru']))
                <li class="{{ Str::startsWith($routeName, ['siswa.', 'kelas.', 'orangtua.', 'guru.', 'tahun-ajaran.', 'wali_kelas.', 'anggota_kelas.']) ? 'active' : '' }}">
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-graduation menu-icon"></i>
                        <span class="nav-text">Akademik</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('siswa.index') }}">Data Siswa</a></li>
                        <li><a href="{{ route('kelas.index') }}">Data Kelas</a></li>
                        <li><a href="{{ route('orangtua.index') }}">Data Orangtua</a></li>
                        <li><a href="{{ route('guru.index') }}">Data Guru</a></li>
                        @if(in_array($role, ['admin', 'kepala_sekolah', 'wali_kelas']))
                            <li><a href="{{ route('tahun-ajaran.index') }}">Data Tahun Ajaran</a></li>
                            <li><a href="{{ route('wali_kelas.index') }}">Data Wali Kelas</a></li>
                            <li><a href="{{ route('anggota_kelas.index') }}">Data Anggota Kelas</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            {{-- PENILAIAN --}}
            @if (in_array($role, ['admin', 'kepala_sekolah', 'wali_kelas']))
                <li class="{{ Str::startsWith($routeName, ['fase.', 'materi_tarbiyah.', 'indikator.', 'surat-hafalan.', 'perkembangan.', 'kondisi-siswa.', 'tujuan.', 'assesment.', 'absensi.', 'monitoring.', 'penilaian_cp.', 'detail_rapor.', 'detail_nilai_hafalan.', 'detail_nilai_tarbiyah.', 'detail_nilai_cp.', 'detail_nilai_p5.']) ? 'active' : '' }}">
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-pencil menu-icon"></i>
                        <span class="nav-text">Penilaian</span>
                    </a>
                    <ul aria-expanded="false">
                        @if(in_array($role, ['admin', 'kepala_sekolah']))
                            <li><a href="{{ route('fase.index') }}">Data Fase</a></li>
                            <li><a href="{{ route('materi_tarbiyah.index') }}">Data Materi</a></li>
                            <li><a href="{{ route('indikator.index') }}">Data Indikator</a></li>
                            <li><a href="{{ route('surat-hafalan.index') }}">Data Hafalan Surat</a></li>
                            <li><a href="{{ route('perkembangan.index') }}">Data Perkembangan</a></li>
                            <li><a href="{{ route('kondisi-siswa.index') }}">Data Kondisi Siswa</a></li>
                            <li><a href="{{ route('monitoring.index') }}">Data Monitoring Semester</a></li>
                            <li><a href="{{ route('penilaian_cp.index') }}">Data Capaian</a></li>
                            <li><a href="{{ route('detail_rapor.index') }}">Data Rapor</a></li>
                        @endif
                        <li><a href="{{ route('tujuan.index') }}">Data Tujuan Pembelajaran</a></li>
                        <li><a href="{{ route('assesment.index') }}">Data Assesment</a></li>
                        <li><a href="{{ route('absensi.index') }}">Data Absensi</a></li>
                        <li><a href="{{ route('detail_nilai_hafalan.index') }}">Penilaian Hafalan</a></li>
                        <li><a href="{{ route('detail_nilai_tarbiyah.index') }}">Penilaian Tarbiyah</a></li>
                        <li><a href="{{ route('detail_nilai_cp.index') }}">Penilaian Capaian</a></li>
                        <li><a href="{{ route('detail_nilai_p5.index') }}">Penilaian P5</a></li>
                    </ul>
                </li>
            @endif

            {{-- LAPORAN --}}
            @if (in_array($role, ['admin', 'wali_kelas', 'kepala_sekolah', 'ortu']))
                <li class="{{ Str::startsWith($routeName, ['laporan-assesment']) ? 'active' : '' }}">
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-docs menu-icon"></i>
                        <span class="nav-text">Laporan</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('laporan-assesment.index') }}">Laporan Mingguan</a></li>
                        <li><a href="{{ route('laporan-semester.index') }}">Laporan Semester</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>

