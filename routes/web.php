<?php

use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\RakController;
use App\Http\Controllers\Admin\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\Karyawan\BarangMasukController;
use App\Http\Controllers\Karyawan\BeliBarangController;
use App\Http\Controllers\Karyawan\KeranjangPesananController;

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

        Route::get('/rak', [RakController::class, 'index'])->name('rak.index');
        Route::get('/rak/create', [RakController::class, 'create'])->name('rak.create');
        Route::post('/rak', [RakController::class, 'store'])->name('rak.store');
        Route::get('/rak/{id}', [RakController::class, 'show'])->name('rak.show');
        Route::get('/rak/{id}/edit', [RakController::class, 'edit'])->name('rak.edit');
        Route::put('/rak/{id}', [RakController::class, 'update'])->name('rak.update');
        Route::delete('/rak/{id}', [RakController::class, 'destroy'])->name('rak.destroy');
        Route::post('rak/{id}/kirimbarang', [RakController::class, 'kirimBarang']);
        Route::get('/rak/{id}/masukkan-barang', [RakController::class, 'masukkanBarang'])->name('rak.masukkan-barang');
        Route::put('/rak/{id}/hapus-barang/{barangId}', [RakController::class, 'hapusBarang'])->name('rak.hapus-barang');
        Route::get('/rak/{id}/cetak-pdf', [RakController::class, 'cetakPDF'])->name('cetak-pdf');

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
        Route::get('/laporan/cetak-pdf', [LaporanController::class, 'cetakPDF'])->name('laporan.cetak-pdf');
    });

    Route::group(['middleware' => 'role:Karyawan'], function () {
        Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
        Route::get('/barang-masuk/barang-baru', [BarangMasukController::class, 'barangBaru'])->name('barang-masuk.barang-baru');
        Route::post('/barang-masuk/barang-baru', [BarangMasukController::class, 'barangBaruStore'])->name('barang-masuk.barang-baru.store');
        Route::get('/barang-masuk/barang-tersedia', [BarangMasukController::class, 'barangTersedia'])->name('barang-masuk.barang-tersedia');
        Route::post('/barang-masuk/barang-tersedia', [BarangMasukController::class, 'barangTersediaStore'])->name('barang-masuk.barang-tersedia.store');

        Route::get('/beli-barang', [BeliBarangController::class, 'index'])->name('beli-barang.index');
        Route::post('/beli-barang/checkout-items', [BeliBarangController::class, 'checkoutItems'])->name('beli-barang.checkout-items');
        Route::get('/beli-barang/checkout', [BeliBarangController::class, 'checkout'])->name('beli-barang.checkout');
        Route::post('/beli-barang/checkout', [BeliBarangController::class, 'checkoutStore'])->name('beli-barang.checkout-store');
        Route::post('/beli-barang/masukkan-keranjang', [BeliBarangController::class, 'masukkanKeranjang'])->name('beli-barang.masukkan-keranjang');
        Route::post('/beli-barang/remove/{key}', [BeliBarangController::class, 'removeItems'])->name('beli-barang.remove-items');

        Route::get('/beli-barang/checkout/{id}', [BeliBarangController::class, 'checkoutKeranjang'])->name('keranjang-pesanan.checkout-keranjang');
        Route::post('/beli-barang/checkout/{id}', [BeliBarangController::class, 'updateCheckoutKeranjang'])->name('keranjang-pesanan.update-checkout-keranjang');
        Route::post('/beli-barang/remove-items-keranjang/{id}', [BeliBarangController::class, 'removeItemsKeranjang'])->name('beli-barang.remove-items-keranjang');

        Route::get('/keranjang-pesanan', [KeranjangPesananController::class, 'index'])->name('keranjang-pesanan.index');
        Route::get('/keranjang-pesanan/{id}', [KeranjangPesananController::class, 'show'])->name('keranjang-pesanan.show');
        Route::delete('/keranjang-pesanan/{id}', [KeranjangPesananController::class, 'destroy'])->name('keranjang-pesanan.destroy');
    });

    Route::post('/logout', [LoginBasic::class, 'destroy']);
});
