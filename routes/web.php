<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\PesertaDidikController;
use App\Http\Controllers\admin\RegistrasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\kepsek\LaporanController;
use App\Http\Controllers\Siswa\SiswaController;


Route::get('/', [DashboardController::class, 'landingpage'])->name('landingpage');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login-proses', [LoginController::class, 'login'])->name('login.process');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Semua yang ada di dalam group ini harus LOGIN terlebih dahulu
Route::middleware('auth')->group(function () {

    // ==========================================
    // KHUSUS ROLE: ADMIN
    // ==========================================
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');
        
        // Manajemen Akun
        Route::get('/manajemen-akun', [UserController::class, 'index'])->name('manajemen_akun');
        Route::get('/manajemen-akun/tambah', [UserController::class, 'create'])->name('manajemen_akun.create');
        Route::post('/manajemen-akun/simpan', [UserController::class, 'store'])->name('manajemen_akun.store');
        Route::get('/manajemen-akun/{id}/sunting', [UserController::class, 'edit'])->name('manajemen_akun.edit');
        Route::put('/manajemen-akun/{id}/perbarui', [UserController::class, 'update'])->name('manajemen_akun.update');
        Route::delete('/manajemen-akun/{id}/hapus', [UserController::class, 'destroy'])->name('manajemen_akun.destroy');
    });

    // ==========================================
    // KHUSUS ROLE: OPERATOR
    // ==========================================
    Route::middleware('role:operator')->group(function () {
        Route::get('/dashboard/operator', [DashboardController::class, 'operator'])->name('operator.dashboard');
    });

    // ==========================================
    // BISA DIAKSES OLEH: ADMIN & OPERATOR
    // ==========================================
    Route::middleware('role:admin,operator')->group(function () {
        // Modul Fitur Utama Manajemen Peserta Didik
        Route::get('/data-peserta', [PesertaDidikController::class, 'index'])->name('data-peserta.index');
        Route::get('/data-peserta/tambah', [PesertaDidikController::class, 'create'])->name('data-peserta.create');
        Route::post('/data-peserta/simpan', [PesertaDidikController::class, 'store'])->name('data-peserta.store');

        Route::get('data-peserta/export-excel', [PesertaDidikController::class, 'exportExcel'])->name('data-peserta.export');
        Route::post('data-peserta/import-excel', [PesertaDidikController::class, 'importExcel'])->name('data-peserta.import');
        Route::get('data-peserta/download-template', [PesertaDidikController::class, 'downloadTemplate'])->name('data-peserta.template');
        
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
    });

    // ==========================================
    // KHUSUS ROLE: KEPALA SEKOLAH
    // ==========================================
    Route::middleware('role:kepsek')->group(function () {
        Route::get('/dashboard/kepala-sekolah', [DashboardController::class, 'kepsek'])->name('kepsek.dashboard');
        Route::get('/kepsek/laporan', [LaporanController::class, 'laporanKepalaSekolah'])->name('laporan.kepsek');
        Route::get('/kepsek/laporan/export', [LaporanController::class, 'exportExcel'])->name('laporan.kepsek.export');
        Route::get('/kepsek/laporan/detail/{id}', [LaporanController::class, 'detail'])->name('laporan.kepsek.detail');
    });

    // ==========================================
    // KHUSUS ROLE: SISWA
    // ==========================================
    Route::middleware('role:siswa')->group(function () {
        Route::get('/dashboard/siswa', [SiswaController::class, 'index'])->name('siswa.dashboard');
        
        // Route untuk mengelola data diri mandiri
        Route::get('/data-diri', [SiswaController::class, 'dataDiri'])->name('siswa.data-diri.index');
        Route::get('/data-diri/Edit', [SiswaController::class, 'editDataDiri'])->name('siswa.data-diri.edit');
        Route::put('/data-diri/update', [SiswaController::class, 'updateDataDiri'])->name('data-diri.update');

        // Route untuk registrasi mandiri
        Route::get('/registrasi/siswa', [SiswaController::class, 'registrasi'])->name('registrasi.siswa');
        Route::post('/registrasi/store', [SiswaController::class, 'storeRegistrasi'])->name('registrasi.siswa.store');
    });
});