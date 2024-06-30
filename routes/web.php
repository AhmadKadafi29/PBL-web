<?php

use App\Http\Controllers\Api\ChartController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\cobaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HargaObatController;
use App\Http\Controllers\KategoriobatController;
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ObatHampirKadaluarsa;
use App\Http\Controllers\ObatKadaluarsaController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanResepController;
use App\Http\Controllers\StokOpnameController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
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
    Route::resource('user', UserController::class);
    Route::resource('Supplier', SupplierController::class);
    Route::resource('Pembelian', PembelianController::class);
    Route::get('obatkadaluarsa', [ObatKadaluarsaController::class, 'index'])->name('Obatkadaluarsa.index');
    Route::get('obathampirkadaluarsa', [ObatHampirKadaluarsa::class, 'index'])->name('Obathampirkadaluarsa.index');
    Route::post('obatkadaluarsa/kadaluarsa', [ObatKadaluarsaController::class, 'storekadaluarsa'])->name('Obatkadaluarsa.storekadaluarsa');
    Route::delete('obatkadaluarsa/{id}', [ObatKadaluarsaController::class, 'destroy'])->name('Obatkadaluarsa.destroy');
    Route::resource('Stok_opname', StokOpnameController::class);
    Route::get('/laporan-penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan-penjualan.index');
    Route::post('/laporan-penjualan/generate', [LaporanPenjualanController::class, 'generate'])->name('laporan-penjualan.generate');
    Route::get('/laporan-penjualan/cetaklaporan', [LaporanPenjualanController::class, 'cetaklaporan'])->name('laporan-penjualan.cetak');
    Route::get('/laporan-pembelian', [LaporanPembelianController::class, 'index'])->name('laporan-pembelian.index');
    Route::post('/laporan-pembelian/generate', [LaporanPembelianController::class, 'generate'])->name('laporan-pembelian.generate');
    Route::get('/laporan-pembelian/cetaklaporan', [LaporanPembelianController::class, 'cetaklaporan'])->name('laporan-pembelian.cetak');
    Route::get('/laporan-labarugi', [LabaRugiController::class, 'index'])->name('labarugi.index');
    Route::post('/laporan-labarugi/generate', [LabaRugiController::class, 'generateLabaRugi'])->name('labarugi.generate');
    Route::get('/laporan-labarugi/cetaklaporan', [LabaRugiController::class, 'printLabaRugi'])->name('labarugi.cetak');
    Route::get('/penjualan/index', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan/cari-obat', [PenjualanController::class, 'cariObat']);
    Route::post('/penjualan/checkout', [PenjualanController::class, 'checkout'])->name('penjualan.checkout');
    Route::post('/penjualan/tambah-keranjang', [PenjualanController::class, 'tambahKeKeranjang']);
    Route::delete('/penjualan/hapus-keranjang', [PenjualanController::class, 'hapusKeranjang'])->name('penjualan.hapus-keranjang');
    Route::delete('/penjualan/hapus-itemkeranjang/{index}', [PenjualanController::class, 'hapusItemKeranjang'])->name('penjualan.hapusItemKeranjang');
    Route::get('/penjualan/cetaknota', [PenjualanController::class, 'cetakNota'])->name('penjualan.cetaknota');

    // Route::middleware(['can:isKaryawan'])->group(function () {
    //     // Rute-rute yang membutuhkan izin 'isKaryawan'
    //     Route::get('penjualan/index', [PenjualanController::class, 'index'])->name('penjualan.index');
    //     Route::post('/penjualan/cari-obat', [PenjualanController::class, 'cariObat']);
    //     Route::post('/penjualan/checkout', [PenjualanController::class, 'checkout']);
    //     Route::post('/penjualan/tambah-keranjang', [PenjualanController::class, 'tambahKeKeranjang']);
    //     Route::delete('/penjualan/hapus-keranjang', [PenjualanController::class, 'hapusKeranjang'])->name('penjualan.hapus-keranjang');
    //     Route::delete('/penjualan/hapus-itemkeranjang/{index}', [PenjualanController::class, 'hapusItemKeranjang'])->name('penjualan.hapusItemKeranjang');
    //     Route::get('/penjualan/cetaknota', [PenjualanController::class, 'cetakNota'])->name('penjualan.cetaknota');

    Route::middleware(['can:isKaryawan'])->group(function () {
        // Rute-rute yang membutuhkan izin 'isKaryawan'
        Route::get('penjualan/index', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::post('/penjualan/cari-obat', [PenjualanController::class, 'cariObat'])->name('penjualan.cariObat');
        Route::post('/penjualan/checkout', [PenjualanController::class, 'checkout'])->name('penjualan.checkout');
        Route::post('/penjualan/tambah-keranjang', [PenjualanController::class, 'tambahKeKeranjang']);
        Route::delete('/penjualan/hapus-keranjang', [PenjualanController::class, 'hapusKeranjang'])->name('penjualan.hapus-keranjang');
        Route::delete('/penjualan/hapus-itemkeranjang/{index}', [PenjualanController::class, 'hapusItemKeranjang'])->name('penjualan.hapusItemKeranjang');
        Route::get('/penjualan/cetaknota', [PenjualanController::class, 'cetakNota'])->name('penjualan.cetaknota');
        // Route::get('/chart/weekly', [ChartController::class, 'weeklyChart']);
        // Route::get('/chart/monthly', [ChartController::class, 'monthlyChart']);
        Route::resource('penjualanresep',PenjualanResepController::class);
        Route::post('/penjualanresep/checkout', [PenjualanResepController::class, 'checkout'])->name('penjualanresep.checkout');
        Route::post('/penjualanresep/tambah-keranjang', [PenjualanResepController::class, 'tambahKeKeranjang']);
        Route::delete('/penjualanresep/hapus-keranjang', [PenjualanResepController::class, 'hapusKeranjang'])->name('penjualanresep.hapus-keranjang');
        Route::delete('/penjualanresep/hapus-itemkeranjang/{index}', [PenjualanResepController::class, 'hapusItemKeranjang'])->name('penjualanresep.hapusItemKeranjang');
        Route::get('/coba', [cobaController::class, 'index']);
    });

    // Route::middleware(['can:isPemilik'])->group(function () {
    //     Route::resource('Supplier', SupplierController::class);
    //     Route::resource('user', UserController::class);
    // });
}); 
