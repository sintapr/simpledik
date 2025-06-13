<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaseController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\OrangtuaController;
use App\Http\Controllers\AssesmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\DetailRaporController;
use App\Http\Controllers\PenilaianCpController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\AnggotaKelasController;
use App\Http\Controllers\KondisiSiswaController;
use App\Http\Controllers\PerkembanganController;
use App\Http\Controllers\SuratHafalanController;
use App\Http\Controllers\DetailNilaiCpController;
use App\Http\Controllers\DetailNilaiP5Controller;
use App\Http\Controllers\MateriTarbiyahController;
use App\Http\Controllers\LaporanAssesmentController;
use App\Http\Controllers\IndikatorTarbiyahController;
use App\Http\Controllers\DetailNilaiHafalanController;
use App\Http\Controllers\MonitoringSemesterController;
use App\Http\Controllers\TujuanPembelajaranController;
use App\Http\Controllers\DetailNilaiTarbiyahController;







Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware('role:orangtua')->get('/dashboard/orangtua', function () {
    return view('dashboard');
})->name('dashboard.orangtua');

Route::middleware('role:admin')->get('/dashboard/admin', function () {
    return view('dashboard');
})->name('dashboard.admin');

// Route::middleware('role:wali_kelas')->get('/dashboard/wali_kelas', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::middleware('role:kepala_sekolah')->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');







/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard');
// })->name('dashboard');



Route::middleware(['role:admin,kepala_sekolah,wali_kelas,siswa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::resource('siswa', SiswaController::class);
Route::resource('kelas', KelasController::class);
Route::resource('guru', GuruController::class);
Route::resource('orangtua', OrangtuaController::class);
Route::resource('tahun-ajaran', TahunAjaranController::class);
Route::resource('fase', FaseController::class);
Route::resource('perkembangan', PerkembanganController::class);
Route::resource('surat-hafalan', SuratHafalanController::class);
Route::resource('tujuan', TujuanPembelajaranController::class);
Route::resource('kondisi-siswa', KondisiSiswaController::class);
Route::resource('materi_tarbiyah', MateriTarbiyahController::class);
Route::resource('indikator', IndikatorTarbiyahController::class);
Route::resource('assesment', AssesmentController::class);
Route::resource('absensi', AbsensiController::class);
Route::resource('monitoring', MonitoringSemesterController::class);
Route::resource('penilaian_cp', PenilaianCpController::class);
Route::resource('detail_rapor', DetailRaporController::class);
Route::resource('detail_nilai_hafalan', DetailNilaiHafalanController::class);
Route::resource('detail_nilai_tarbiyah', DetailNilaiTarbiyahController::class);
Route::resource('detail_nilai_cp', DetailNilaiCpController::class);
Route::resource('detail_nilai_p5', DetailNilaiP5Controller::class);
Route::resource('wali_kelas', WaliKelasController::class);
Route::resource('anggota_kelas', AnggotaKelasController::class);



Route::prefix('laporan-assesment')->name('laporan-assesment.')->group(function () {
    Route::get('/', [LaporanAssesmentController::class, 'index'])->name('index');
    Route::get('/{id_kelas}/{id_ta}', [LaporanAssesmentController::class, 'showByKelas'])->name('showByKelas');
    Route::get('/assesment/{nis}/{id_tp}/{id_ta}', [LaporanAssesmentController::class, 'showDetail'])->name('showDetail');

    // Ubah nama route agar unik
    Route::get('/cetak/{nis}/{id_kelas}/{id_ta}', [LaporanAssesmentController::class, 'cetakPdf'])->name('cetak');
    Route::get('/cetak/{nis}/{id_kelas}/{id_ta}/{minggu}', [LaporanAssesmentController::class, 'cetakPdfMinggu'])->name('cetak.mingguan');

    Route::get('/notify/{nis}/{id_ta}/{id_kelas}/{minggu}', [LaporanAssesmentController::class, 'showNotifyForm'])->name('edit');
    Route::post('/notify/{nis}/{id_ta}/{id_kelas}/{minggu}', [LaporanAssesmentController::class, 'sendNotification'])->name('laporan.notify');
});


// Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'edit'])->name('profil');
// Route::post('/profil', [App\Http\Controllers\ProfilController::class, 'update'])->name('profil.update');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/profil', [ProfilController::class, 'show'])->name('profil');
Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');



use App\Http\Controllers\LaporanSemesterController;


// Route::prefix('laporan-semester')->name('laporan-semester.')->group(function () {
//     Route::get('/', [LaporanSemesterController::class, 'index'])->name('index');
//     // Route::get('/{id_kelas}', [LaporanSemesterController::class, 'detail'])->name('detail');
//     Route::get('/{nis}/{semester}/cetak', [LaporanSemesterController::class, 'cetakRapor'])->name('cetak');
//     Route::get('/{nis}/{semester}', [LaporanSemesterController::class, 'show'])->name('semester');

//     Route::get('/rapor/{id_kelas}/{id_ta}', [LaporanSemesterController::class, 'rapor'])->name('rapor');
//     Route::get('/laporan/{id_kelas}/{id_ta}/rapor', [LaporanSemesterController::class, 'rapor'])->name('laporan-semester.rapor');
//     Route::get('/laporan-semester/{nis}/{id_ta}', [LaporanSemesterController::class, 'show'])->name('laporan.show');
// Route::get('/laporan-semester/detail/{id_kelas}/{id_ta}', [LaporanSemesterController::class, 'detail'])->name('laporan-semester.detail');

// });

Route::prefix('laporan-semester')->name('laporan-semester.')->group(function () {
    // Halaman utama: daftar kelas & tahun ajaran
    Route::get('/', [LaporanSemesterController::class, 'index'])->name('index');
    // Detail kelas dan wali kelas
    Route::get('/detail/{id_kelas}/{id_ta?}', [LaporanSemesterController::class, 'detail'])->name('detail');
    // Lihat rapor siswa (HTML)
    Route::get('/show/{nis}/{id_ta}/{semester}', [LaporanSemesterController::class, 'show'])->name('laporan.show');
    // Edit rapor untuk kirim notifikasi atau update info
    Route::get('/edit/{nis}/{id_ta}', [LaporanSemesterController::class, 'edit'])->name('laporan.edit');
    // Cetak rapor PDF
    Route::get('/cetak/{nis}/{id_ta}/{semester}', [LaporanSemesterController::class, 'cetakRapor'])->name('laporan.cetak');
    // Daftar semua rapor dalam 1 kelas
    Route::get('/rapor/{id_kelas}/{id_ta}', [LaporanSemesterController::class, 'rapor'])->name('rapor');
    Route::get('/notify/{nis}/{id_ta}/{id_kelas}', [LaporanSemesterController::class, 'notify'])->name('laporan.notify.form');
    Route::post('/notify/{nis}/{id_ta}/{id_kelas}', [LaporanSemesterController::class, 'notify'])->name('laporan.notify.send');

// Akses rapor oleh orangtua (login sebagai siswa)
Route::get('/laporan-orangtua', [LaporanSemesterController::class, 'ortu'])->name('laporan.ortu');

});

Route::get('/laporan-semester/ortu', [LaporanSemesterController::class, 'ortu'])
    ->name('laporan-semester.ortu')
    ->middleware('auth:siswa'); // pastikan hanya siswa/orangtua yg bisa akses



use App\Http\Controllers\NotifikasiController;
// Route::post('/laporan-semester/notify/{nis}/{id_ta}', [NotifikasiController::class, 'kirimPerSiswa'])
//     ->name('laporan-semester.laporan.notify');

Route::middleware(['auth'])->group(function() {
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    // Route::get('/notifikasi/{id}/buka', [NotifikasiController::class, 'buka'])->name('notifikasi.buka');

});




Route::get('/generate-id-rapor', [MonitoringSemesterController::class, 'generateIdRapor'])->name('monitoring.generateIdRapor');

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
