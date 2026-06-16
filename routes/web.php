<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\admin\PesertaDidikController;
use App\Http\Controllers\admin\RegistrasiController;
use App\Http\Controllers\admin\RincianDataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\admin\UserController;

Route::middleware('guest')->group(function () {

    Route::get('/', [LoginController::class, 'index'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.process');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Manajemen Akun (Khusus Admin)
    Route::get('/manajemen-akun', [UserController::class, 'index'])->name('manajemen_akun');
    Route::get('/manajemen-akun/tambah', [UserController::class, 'create'])->name('manajemen_akun.create');
    Route::post('/manajemen-akun/simpan', [UserController::class, 'store'])->name('manajemen_akun.store');
    Route::get('/manajemen-akun/{id}/sunting', [UserController::class, 'edit'])->name('manajemen_akun.edit');
    Route::put('/manajemen-akun/{id}/perbarui', [UserController::class, 'update'])->name('manajemen_akun.update');
    Route::delete('/manajemen-akun/{id}/hapus', [UserController::class, 'destroy'])->name('manajemen_akun.destroy');

    // Modul Fitur Utama Manajemen Peserta Didik
    Route::get('/data-peserta', [PesertaDidikController::class, 'index'])->name('data-peserta');
    Route::get('data-peserta/export-excel', [PesertaDidikController::class, 'exportExcel'])->name('data-peserta.export');
    Route::post('data-peserta/import-excel', [PesertaDidikController::class, 'importExcel'])->name('data-peserta.import');
    Route::get('data-peserta/download-template', [PesertaDidikController::class, 'downloadTemplate'])->name('data-peserta.template');
    Route::get('/data-peserta/tambah', [PesertaDidikController::class, 'create'])->name('data-peserta.create');
    Route::post('/data-peserta/simpan', [PesertaDidikController::class, 'store'])->name('data-peserta.store');
    Route::get('/data-peserta/detail/{id}', [PesertaDidikController::class, 'show'])->name('data-peserta.detail');
    Route::get('/data-peserta/{id}/sunting', [PesertaDidikController::class, 'edit'])->name('data-peserta.edit');
    Route::put('/data-peserta/{id}/perbarui', [PesertaDidikController::class, 'update'])->name('data-peserta.update');
    Route::delete('/data-peserta/{id}/hapus', [PesertaDidikController::class, 'destroy'])->name('data-peserta.destroy');

    // Registrasi (Form & Proses Simpan)
    Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi.index');
    Route::get('/registrasi/create', [RegistrasiController::class, 'create'])->name('registrasi.create');
    Route::post('/registrasi', [RegistrasiController::class, 'store'])->name('registrasi.store');
    Route::get('/registrasi/{id}/detail', [RegistrasiController::class, 'show'])->name('registrasi.detail');
    Route::get('/registrasi/{id}/edit', [RegistrasiController::class, 'edit'])->name('registrasi.edit');
    Route::put('/registrasi/{id}', [RegistrasiController::class, 'update'])->name('registrasi.update');
    Route::delete('/registrasi/{id}', [RegistrasiController::class, 'destroy'])->name('registrasi.destroy');

    Route::view('/operator/dashboard', 'operator.dashboard')
        ->name('operator.dashboard');

    Route::view('/kepsek/dashboard', 'kepsek.dashboard')
        ->name('kepsek.dashboard');
});
