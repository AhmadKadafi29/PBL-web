<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriobatController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ObatKadaluarsaController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StokOpnameController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pages.auth.auth-login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('home', [DashboardController::class, 'index'])->name('home');
    Route::resource('Obat', ObatController::class);
    Route::resource('Kategori', KategoriobatController::class);
    Route::resource('Supplier', SupplierController::class);
    Route::resource('Pembelian', PembelianController::class);
    Route::get('obatkadaluarsa', [ObatKadaluarsaController::class, 'index'])->name('Obatkadaluarsa.index');
    Route::post('obatkadaluarsa/kadaluarsa', [ObatKadaluarsaController::class, 'storekadaluarsa'])->name('Obatkadaluarsa.storekadaluarsa');
    Route::post('obatkadaluarsa', [ObatKadaluarsaController::class, 'destroy'])->name('Obatkadaluarsa.destroy');
    Route::resource('Stok_opname', StokOpnameController::class);
    Route::get('penjualan/index', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan/cari-obat', [PenjualanController::class, 'cariObat']);
    Route::post('/penjualan/checkout', [PenjualanController::class, 'checkout']);
    Route::post('/penjualan/tambah-keranjang', [PenjualanController::class, 'tambahKeKeranjang']);
    Route::delete('/penjualan/hapus-keranjang', [PenjualanController::class, 'hapusKeranjang'])->name('penjualan.hapus-keranjang');
    Route::delete('/penjualan/hapus-itemkeranjang/{index}', [PenjualanController::class, 'hapusItemKeranjang'])->name('penjualan.hapusItemKeranjang');
    Route::get('/laporan-penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan-penjualan.index');
    Route::post('/laporan-penjualan/generate', [LaporanPenjualanController::class, 'generate'])->name('laporan-penjualan.generate');
    Route::get('/laporan-pembelian', [LaporanPembelianController::class, 'index'])->name('laporan-pembelian.index');
    Route::post('/laporan-pembelian/generate', [LaporanPembelianController::class, 'generate'])->name('laporan-pembelian.generate');
    // routes/web.php
    Route::get('/sales-chart-data', [DashboardController::class, 'chart'])->name('sales.chart.data');
});
