<?php

use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\Karyawan\BarangKeluarController;
use App\Http\Controllers\Karyawan\BarangMasukController;

// Main Page Route
// Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');
    Route::post('/', [LoginBasic::class, 'store']);
    // Route::get('/register', [RegisterBasic::class, 'index'])->name('auth-register-basic');
    // Route::post('/register', [RegisterBasic::class, 'store']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => 'role:Admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
        Route::get('/barang/hasil-klasifikasi-perhitungan', [BarangController::class, 'hasilKlasifikasiPerhitungan'])->name('barang.hasil-klasifikasi-perhitungan.show');
        Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
        Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
        Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    Route::group(['middleware' => 'role:Karyawan'], function () {
        Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
        Route::get('/barang-masuk/barang-baru', [BarangMasukController::class, 'barangBaru'])->name('barang-masuk.barang-baru');
        Route::post('/barang-masuk/barang-baru', [BarangMasukController::class, 'barangBaruStore'])->name('barang-masuk.barang-baru.store');
        Route::get('/barang-masuk/barang-tersedia', [BarangMasukController::class, 'barangTersedia'])->name('barang-masuk.barang-tersedia');
        Route::post('/barang-masuk/barang-tersedia', [BarangMasukController::class, 'barangTersediaStore'])->name('barang-masuk.barang-tersedia.store');

        Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
        Route::get('/barang-keluar/create', [BarangKeluarController::class, 'create'])->name('barang-keluar.create');
        Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
    });

    Route::post('/logout', [LoginBasic::class, 'destroy']);
});
