<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\KoordinatorController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\NilaiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth.session', 'mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
    Route::post('/mahasiswa/kelompok', [MahasiswaController::class, 'storeKelompok'])->name('mahasiswa.store_kelompok');
    Route::get('/mahasiswa/logbook', [LogbookController::class, 'index'])->name('logbook.index');
    Route::post('/mahasiswa/logbook', [LogbookController::class, 'store'])->name('logbook.store');
    Route::put('/mahasiswa/logbook/{id}', [LogbookController::class, 'update'])->name('logbook.update');
    Route::delete('/mahasiswa/logbook/{id}', [LogbookController::class, 'destroy'])->name('logbook.destroy');
    Route::get('/mahasiswa/tugas', [MahasiswaController::class, 'tugas'])->name('mahasiswa.tugas');
    Route::get('/mahasiswa/tugas/{id}/download', [MahasiswaController::class, 'downloadTugasDosen'])->name('mahasiswa.tugas.download');
    Route::get('/mahasiswa/tugas/{id}/upload', [MahasiswaController::class, 'uploadTugas'])->name('mahasiswa.tugas.upload');
    Route::post('/mahasiswa/tugas/{id}/upload', [MahasiswaController::class, 'uploadTugas'])->name('mahasiswa.tugas.upload');
});



Route::get('/dashboard/koordinator', [KoordinatorController::class, 'dashboard'])->name('koordinator.dashboard');
Route::post('/koordinator/update-pembimbing', [KoordinatorController::class, 'updatePembimbing'])->name('koordinator.update-pembimbing');

Route::middleware(['auth.session', 'dosen'])->group(function () {
    Route::get('/dosen/dashboard', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
    Route::get('/dosen/tugas', [TugasController::class, 'index'])->name('dosen.tugas');
    Route::get('/dosen/tugas/tambah', [TugasController::class, 'create'])->name('dosen.tugas.create');
    Route::post('/dosen/tugas/store', [TugasController::class, 'store'])->name('dosen.tugas.store');
    Route::get('/dosen/tugas/{id}/download', [TugasController::class, 'download'])->name('dosen.tugas.download');
    Route::get('/dosen/logbook', [LogbookController::class, 'showLogbook'])->name('dosen.logbook');
    Route::get('/dosen/logbook/{nim}', [LogbookController::class, 'detailLogbook'])->name('dosen.logbook.detail');
    Route::get('/dosen/nilai', [NilaiController::class, 'index'])->name('dosen.nilai');
    Route::get('/dosen/tugas/{id}/peserta', [TugasController::class, 'peserta'])->name('dosen.tugas.peserta');
    Route::get('/dosen/tugas/{id}/download/{id_klp}', [TugasController::class, 'download'])->name('dosen.tugas.download.mhs');
    Route::get('/dosen/tugas/{id}/nilai/{id_tugas_kelompok}/edit', [TugasController::class, 'formNilai'])->name('dosen.tugas.nilai.form');
    Route::post('/dosen/tugas/{id}/nilai/{id_tugas_kelompok}/simpan', [TugasController::class, 'simpanNilai'])->name('dosen.tugas.nilai.simpan');
});

Route::get('/api/mahasiswa/{nim}', [MahasiswaController::class, 'getByNim']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
