<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KurikulumController;

Route::get('/', [KurikulumController::class, 'index'])->name('kurikulum.index');
Route::get('/kurikulum', [KurikulumController::class, 'index'])->name('kurikulum.home');
Route::get('/jurusan/{id}', [KurikulumController::class, 'jurusanDetail'])->name('kurikulum.jurusan.detail');
Route::get('/kelas/{id}', [KurikulumController::class, 'kelasDetail'])->name('kurikulum.kelas.detail');

// Absensi Routes
Route::get('/absensi', [KurikulumController::class, 'absensiIndex'])->name('kurikulum.absensi.index');
Route::get('/absensi/{id}/edit', [KurikulumController::class, 'absensiEdit'])->name('kurikulum.absensi.edit');
Route::post('/absensi', [KurikulumController::class, 'absensiStore'])->name('kurikulum.absensi.store');
Route::put('/absensi/{id}', [KurikulumController::class, 'absensiUpdate'])->name('kurikulum.absensi.update');
Route::delete('/absensi/{id}', [KurikulumController::class, 'absensiDestroy'])->name('kurikulum.absensi.destroy');

// Siswa Routes
Route::get('/siswa', [KurikulumController::class, 'siswaIndex'])->name('kurikulum.siswa.index');
Route::get('/siswa/{id}/edit', [KurikulumController::class, 'siswaEdit'])->name('kurikulum.siswa.edit');
Route::post('/siswa', [KurikulumController::class, 'siswaStore'])->name('kurikulum.siswa.store');
Route::put('/siswa/{id}', [KurikulumController::class, 'siswaUpdate'])->name('kurikulum.siswa.update');
Route::delete('/siswa/{id}', [KurikulumController::class, 'siswaDestroy'])->name('kurikulum.siswa.destroy');

// Jadwal Routes
Route::get('/jadwal', [KurikulumController::class, 'jadwalIndex'])->name('kurikulum.jadwal.index');
Route::get('/jadwal/{id}/edit', [KurikulumController::class, 'jadwalEdit'])->name('kurikulum.jadwal.edit');
Route::post('/jadwal', [KurikulumController::class, 'jadwalStore'])->name('kurikulum.jadwal.store');
Route::put('/jadwal/{id}', [KurikulumController::class, 'jadwalUpdate'])->name('kurikulum.jadwal.update');
Route::delete('/jadwal/{id}', [KurikulumController::class, 'jadwalDestroy'])->name('kurikulum.jadwal.destroy');

// Guru Routes
Route::get('/guru', [KurikulumController::class, 'guruIndex'])->name('kurikulum.guru.index');
Route::get('/guru/{id}/edit', [KurikulumController::class, 'guruEdit'])->name('kurikulum.guru.edit');
Route::post('/guru', [KurikulumController::class, 'guruStore'])->name('kurikulum.guru.store');
Route::put('/guru/{id}', [KurikulumController::class, 'guruUpdate'])->name('kurikulum.guru.update');
Route::delete('/guru/{id}', [KurikulumController::class, 'guruDestroy'])->name('kurikulum.guru.destroy');

// Wali Kelas Routes
Route::get('/wali-kelas', [KurikulumController::class, 'kelasIndex'])->name('kurikulum.kelas.index');
Route::get('/wali-kelas/{id}/edit', [KurikulumController::class, 'kelasEdit'])->name('kurikulum.kelas.edit');
Route::put('/wali-kelas/{id}', [KurikulumController::class, 'kelasUpdate'])->name('kurikulum.kelas.update');
Route::post('/wali-kelas/acak', [KurikulumController::class, 'kelasAcak'])->name('kurikulum.kelas.acak');
Route::post('/wali-kelas/reset', [KurikulumController::class, 'kelasReset'])->name('kurikulum.kelas.reset');

// Auth Routes
Route::get('/login', [KurikulumController::class, 'loginForm'])->name('kurikulum.login');
Route::post('/login', [KurikulumController::class, 'loginPost'])->name('kurikulum.login.post');
Route::get('/logout', [KurikulumController::class, 'logout'])->name('kurikulum.logout');

// Fallback ke PHP native untuk halaman lain
Route::get('/{any}', function () {
    return redirect('/kurikulum/index.php');
})->where('any', '.*');
