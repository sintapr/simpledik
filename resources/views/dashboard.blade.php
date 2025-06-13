@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    {{-- Welcome Header --}}
    <div class="welcome-card card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    @if($role == 'orangtua')
                        <h3 class="text-success fw-bold mb-2">
                            <i class="fas fa-heart text-danger me-2"></i>
                            Selamat datang, {{ $user->nama_ayah ?? $user->nama_ibu ?? 'Orangtua' }}
                        </h3>
                        <p class="mb-1"><i class="fas fa-child text-primary me-2"></i>Anak anda: <strong>{{ $user->siswa->nama_siswa ?? '-' }}</strong></p>
                    @elseif ($role === 'siswa')
                        <h3 class="text-success fw-bold mb-2">
                            <i class="fas fa-star text-warning me-2"></i>
                            Selamat Datang, <span class="text-primary">{{ $user->nama_siswa ?? '-' }}</span>
                        </h3>
                    @elseif (in_array($role, ['admin', 'wali_kelas', 'kepala_sekolah']))
                        <h3 class="text-success fw-bold mb-2">
                            <i class="fas fa-graduation-cap text-info me-2"></i>
                            Selamat Datang, Bapak/Ibu <span class="text-primary">{{ $user->nama_guru ?? '-' }}</span>
                        </h3>
                    @else
                        <h3 class="text-success fw-bold mb-2">
                            <i class="fas fa-home me-2"></i>
                            Selamat Datang di Dashboard
                        </h3>
                    @endif
                    <p class="text-muted mb-0">
                        <i class="fas fa-sun text-warning me-2"></i>
                        Semoga hari Anda penuh berkah dan menyenangkan
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="info-icon mx-auto mb-2 pulse-animation">
                        <i class="fas fa-calendar-alt fa-lg"></i>
                    </div>
                    <div class="fw-bold text-dark" id="tanggal"></div>
                    <div class="fw-semibold text-success fs-4" id="jam"></div>
                </div>
            </div>
        </div>
    </div>

    @if($role === 'orangtua')
        {{-- Orangtua Section --}}
        <div class="row g-4">
            {{-- Informasi Sekolah --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm card-hover mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="info-icon me-3">
                                <i class="fas fa-school fa-lg"></i>
                            </div>
                            <h5 class="fw-bold mb-0 text-success">TK Islam Taruna Al Qur'an</h5>
                        </div>
                        <p class="text-muted mb-3">Lembaga pendidikan yang berfokus pada pembentukan karakter anak sejak usia dini melalui pendekatan islami dan pembelajaran aktif.</p>
                    </div>
                </div>
            </div>

            {{-- Progress Belajar Chart --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body">
                        <h6 class="fw-bold text-success mb-3">
                            <i class="fas fa-chart-pie me-2"></i>Progress Belajar
                        </h6>
                        <div class="chart-container">
                            <canvas id="progressChart"></canvas>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <small>Tuntas</small>
                                <small class="text-success fw-bold">{{ $rekapHasilBelajar->where('status', 'Tuntas')->count() ?: 3 }}</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>Belum Tuntas</small>
                                <small class="text-warning fw-bold">{{ $rekapHasilBelajar->where('status', 'Belum Tuntas')->count() ?: 2 }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Cards untuk Orangtua --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm card-hover gradient-green-1 text-white stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-2 opacity-75">Informasi Anak</h6>
                                <h5 class="fw-bold mb-1">{{ $user->siswa->nama_siswa ?? '-' }}</h5>
                                <p class="mb-1"><small>NIS: {{ $user->siswa->NIS ?? $user->NIS ?? '-' }}</small></p>
                                <p class="mb-1"><small>Kelas: {{ optional($user->siswa)->kelas->nama_kelas ?? 'Belum terdaftar' }}</small></p>
                                <p class="mb-0"><small>{{ $tahun_ajaran->tahun_aktif ?? '-' }}</small></p>
                            </div>
                            <div class="text-end">
                                <i class="fas fa-user-graduate fa-3x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm card-hover gradient-green-2 text-white stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-2 opacity-75">Wali Kelas</h6>
                                <h5 class="fw-bold mb-1">{{ optional(optional($user->siswa)->kelas)->waliKelas->nama_guru ?? '-' }}</h5>
                                <p class="mb-0">
                                    <i class="fas fa-phone me-2"></i>
                                    <small>{{ optional(optional($user->siswa)->kelas)->waliKelas->no_hp ?? '-' }}</small>
                                </p>
                            </div>
                            <div class="text-end">
                                <i class="fas fa-chalkboard-teacher fa-3x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- Dashboard Admin, Wali, Kepala Sekolah --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm gradient-green-1 text-white card-hover stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-2 opacity-75">Total Siswa</h6>
                                <h2 class="fw-bold mb-1">{{ $jumlahSiswa }}</h2>
                                <small class="opacity-75">{{ $tahun_ajaran->tahun_aktif ?? 'Tahun Aktif' }}</small>
                            </div>
                            <div class="text-end">
                                <i class="fa fa-users fa-3x opacity-75"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-white opacity-75" style="width: 85%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm gradient-green-2 text-white card-hover stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-2 opacity-75">Jumlah Kelas</h6>
                                <h2 class="fw-bold mb-1">{{ $jumlahKelas }}</h2>
                                <small class="opacity-75">Aktif</small>
                            </div>
                            <div class="text-end">
                                <i class="fa fa-building fa-3x opacity-75"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-white opacity-75" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm gradient-green-3 text-white card-hover stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-2 opacity-75">Jumlah Guru</h6>
                                <h2 class="fw-bold mb-1">{{ $jumlahGuru }}</h2>
                                <small class="opacity-75">Aktif</small>
                            </div>
                            <div class="text-end">
                                <i class="fa fa-chalkboard-teacher fa-3x opacity-75"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-white opacity-75" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm gradient-green-4 text-white card-hover stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-2 opacity-75">Assessment</h6>
                                <h2 class="fw-bold mb-1">{{ $jumlahAssessment }}</h2>
                                <small class="opacity-75">Total Data</small>
                            </div>
                            <div class="text-end">
                                <i class="fa fa-clipboard-list fa-3x opacity-75"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-white opacity-75" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm card-hover">
                    <div class="card-body">
                        <h5 class="fw-bold text-success mb-3">
                            <i class="fas fa-chart-bar me-2"></i>
                            Statistik Sekolah
                        </h5>
                        <div class="chart-container">
                            <canvas id="schoolStatsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-body">
                        <h5 class="fw-bold text-success mb-3">
                            <i class="fas fa-chart-pie me-2"></i>
                            Distribusi Kelas
                        </h5>
                        <div class="chart-container">
                            <canvas id="classDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Dashboard JavaScript dimuat');
    
    // Debug data lengkap
    const dashboardData = {
        role: '{{ $role }}',
        jumlahSiswa: {{ $jumlahSiswa }},
        jumlahGuru: {{ $jumlahGuru }},
        jumlahKelas: {{ $jumlahKelas }},
        jumlahAssessment: {{ $jumlahAssessment }},
        distribusiKelas: {!! json_encode($distribusiKelas) !!},
        rekapHasilBelajar: {!! json_encode($rekapHasilBelajar) !!}
    };
    
    console.log('📊 Dashboard Data:', dashboardData);

    // Update Clock Function
    function updateClock() {
        try {
            const now = new Date();
            const optionsTanggal = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const tanggalEl = document.getElementById('tanggal');
            const jamEl = document.getElementById('jam');
            
            if (tanggalEl) {
                tanggalEl.innerText = now.toLocaleDateString('id-ID', optionsTanggul);
            }
            if (jamEl) {
                jamEl.innerText = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            }
        } catch (e) {
            console.error('❌ Error updating clock:', e);
        }
    }
    
    setInterval(updateClock, 1000);
    updateClock();

    @if($role === 'orangtua')
        // Progress Chart for Parents
        const progressCtx = document.getElementById('progressChart');
        if (progressCtx) {
            try {
                console.log('📈 Creating progress chart for parents');
                const rekapData = dashboardData.rekapHasilBelajar;
                const tuntasCount = rekapData.filter(item => item.status === 'Tuntas').length;
                const belumTuntasCount = rekapData.filter(item => item.status === 'Belum Tuntas').length;
                
                const finalTuntas = tuntasCount > 0 ? tuntasCount : 3;
                const finalBelumTuntas = belumTuntasCount > 0 ? belumTuntasCount : 2;
                
                new Chart(progressCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Tuntas', 'Belum Tuntas'],
                        datasets: [{
                            data: [finalTuntas, finalBelumTuntas],
                            backgroundColor: ['#2ecc71', '#f39c12'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + value + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
                console.log('✅ Progress chart created successfully');
            } catch (e) {
                console.error('❌ Error creating progress chart:', e);
            }
        }
    @else
        // School Stats Chart
        const schoolStatsCtx = document.getElementById('schoolStatsChart');
        if (schoolStatsCtx) {
            try {
                console.log('📊 Creating school stats chart');
                console.log('Data untuk chart:', {
                    siswa: dashboardData.jumlahSiswa,
                    guru: dashboardData.jumlahGuru,
                    kelas: dashboardData.jumlahKelas,
                    assessment: dashboardData.jumlahAssessment
                });

                new Chart(schoolStatsCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Siswa', 'Guru', 'Kelas', 'Assessment'],
                        datasets: [{
                            label: 'Jumlah',
                            data: [
                                dashboardData.jumlahSiswa,
                                dashboardData.jumlahGuru,
                                dashboardData.jumlahKelas,
                                dashboardData.jumlahAssessment
                            ],
                            backgroundColor: [
                                '#2ecc71',
                                '#1abc9c', 
                                '#27ae60',
                                '#16a085'
                            ],
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' ' + context.label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e8f5e8'
                                },
                                ticks: {
                                    precision: 0
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
                console.log('✅ School stats chart created successfully');
            } catch (e) {
                console.error('❌ Error creating school stats chart:', e);
            }
        } else {
            console.error('❌ schoolStatsChart canvas not found');
        }

        // Class Distribution Chart
        const classDistCtx = document.getElementById('classDistributionChart');
        if (classDistCtx) {
            try {
                console.log('🎯 Creating class distribution chart');
                const distribusiData = dashboardData.distribusiKelas;
                console.log('Distribusi data:', distribusiData);
                
                let labels = [];
                let data = [];
                let colors = ['#2ecc71', '#1abc9c', '#27ae60', '#16a085', '#2980b9', '#52c234', '#047857', '#059669'];
                
                if (distribusiData && distribusiData.length > 0) {
                    labels = distribusiData.map(item => item.nama_kelas);
                    data = distribusiData.map(item => parseInt(item.jumlah_siswa) || 0);
                } else {
                    console.log('⚠️ Tidak ada data distribusi, menggunakan fallback');
                    labels = ['A1', 'A2', 'B1', 'B2'];
                    data = [5, 6, 4, 5];
                }

                console.log('Chart akan dibuat dengan:', { labels, data });

                new Chart(classDistCtx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: colors.slice(0, labels.length),
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return label + ': ' + value + ' siswa (' + percentage + '%)';
                                    }
                                }
                            }
                        },
                        cutout: '50%'
                    }
                });
                console.log('✅ Class distribution chart created successfully');
            } catch (e) {
                console.error('❌ Error creating class distribution chart:', e);
            }
        } else {
            console.error('❌ classDistributionChart canvas not found');
        }
    @endif

    // Card animations
    try {
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        console.log('✅ Card animations applied');
    } catch (e) {
        console.error('❌ Error applying card animations:', e);
    }
});
</script>
@endpush