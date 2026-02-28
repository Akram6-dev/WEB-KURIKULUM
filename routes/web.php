<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KurikulumController;

Route::get('/', [KurikulumController::class, 'index'])->name('kurikulum.index');
Route::get('/kurikulum', [KurikulumController::class, 'index'])->name('kurikulum.home');

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

// Materi Routes
Route::get('/materi', [KurikulumController::class, 'materiIndex'])->name('kurikulum.materi.index');
Route::get('/materi/{id}/edit', [KurikulumController::class, 'materiEdit'])->name('kurikulum.materi.edit');
Route::post('/materi', [KurikulumController::class, 'materiStore'])->name('kurikulum.materi.store');
Route::put('/materi/{id}', [KurikulumController::class, 'materiUpdate'])->name('kurikulum.materi.update');
Route::delete('/materi/{id}', [KurikulumController::class, 'materiDestroy'])->name('kurikulum.materi.destroy');

// Guru Routes
Route::get('/guru', [KurikulumController::class, 'guruIndex'])->name('kurikulum.guru.index');
Route::get('/guru/{id}/edit', [KurikulumController::class, 'guruEdit'])->name('kurikulum.guru.edit');
Route::post('/guru', [KurikulumController::class, 'guruStore'])->name('kurikulum.guru.store');
Route::put('/guru/{id}', [KurikulumController::class, 'guruUpdate'])->name('kurikulum.guru.update');
Route::delete('/guru/{id}', [KurikulumController::class, 'guruDestroy'])->name('kurikulum.guru.destroy');

// Auth Routes
Route::get('/login', [KurikulumController::class, 'loginForm'])->name('kurikulum.login');
Route::post('/login', [KurikulumController::class, 'loginPost'])->name('kurikulum.login.post');
Route::get('/logout', [KurikulumController::class, 'logout'])->name('kurikulum.logout');

// Fallback ke PHP native untuk halaman lain
Route::get('/{any}', function () {
    return redirect('/kurikulum/index.php');
})->where('any', '.*');
