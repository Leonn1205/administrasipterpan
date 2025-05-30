<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\KoordinatorController;
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
    Route::post('/mahasiswa/kelompok', [MahasiswaController::class, 'storeKelompok']);
});

Route::get('/mahasiswa/logbook', [LogbookController::class, 'index'])->name('logbook.index');
Route::post('/mahasiswa/logbook', [LogbookController::class, 'store'])->name('logbook.store');
Route::put('/mahasiswa/logbook/{id}', [LogbookController::class, 'update'])->name('logbook.update');
Route::delete('/mahasiswa/logbook/{id}', [LogbookController::class, 'destroy'])->name('logbook.destroy');

Route::get('/dashboard/koordinator', [KoordinatorController::class, 'dashboard'])->name('koordinator.dashboard');
Route::post('/koordinator/update-pembimbing', [KoordinatorController::class, 'updatePembimbing'])->name('koordinator.update-pembimbing');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
