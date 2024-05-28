<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ObatController as ApiObatController;
use App\Http\Controllers\Api\PembelianController;
use App\Http\Controllers\Api\PenjualanController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SupplierController as ApiSupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriobatController;
use App\Http\Controllers\Api\KeuntunganController;
use App\Http\Controllers\Api\ObatKadaluarsaController;
use App\Http\Controllers\Api\StockOpnameController;
use App\Http\Controllers\ObatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);

Route::get('/obat', [ApiObatController::class, 'index']);
Route::get('/obat_hampir_kadaluarsa', [ApiObatController::class, 'hampir_kadaluarsa'])->middleware(['auth:sanctum']);
Route::get('/supplier', [ApiSupplierController::class, 'index'])->middleware(['auth:sanctum']);
Route::put('/supplier/{id}',[ApiSupplierController::class, 'update']);
Route::get('/obat_kadaluarsa', [ObatKadaluarsaController::class, 'index'])->middleware(['auth:sanctum']);

Route::get('/user', [UserController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/user', [UserController::class, 'store'])->middleware(['auth:sanctum']);
Route::put('/user/{id}', [UserController::class, 'update'])->middleware(['auth:sanctum']);
Route::post('/user/{id}', [UserController::class, 'delete'])->middleware(['auth:sanctum']);

Route::get('/profile', [ProfileController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/edit_profile', [ProfileController::class, 'edit'])->middleware(['auth:sanctum']);
Route::post('/profile/updatepassword', [ProfileController::class, 'updatePassword'])->middleware(['auth:sanctum']);

Route::get('/pembelian', [PembelianController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/laporan_pembelian/{id}/{tahun}', [PembelianController::class, 'getLapPembelian'])->middleware(['auth:sanctum']);

Route::get('/penjualan', [PenjualanController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/total_penjualan_perbulan/{id}', [PenjualanController::class, 'getTotalPenjualan'])->middleware(['auth:sanctum']);
Route::get('/penjualan_teratas/{id}', [PenjualanController::class, 'PenjualanTeratas'])->middleware(['auth:sanctum']);
Route::get('/keuntungan_perbulan/{id}', [KeuntunganController::class, 'Keuntungan'])->middleware(['auth:sanctum']);

Route::get('/opname', [StockOpnameController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/grafik/{id}', [PenjualanController::class, 'statistik'])->middleware(['auth:sanctum']);
Route::get('/laporan_penjualan/{id}/{tahun}', [PenjualanController::class, 'getLapPenjualan'])->middleware(['auth:sanctum']);
Route::get('/total_penjualan/{id}/{tahun}', [PenjualanController::class, 'TotalPenjualan'])->middleware(['auth:sanctum']);
Route::get('/laporan_pembelian/{id}/{tahun}', [PembelianController::class, 'getLapPembelian'])->middleware(['auth:sanctum']);
Route::get('/total_pembelian/{id}/{tahun}', [PembelianController::class, 'TotalPembelian'])->middleware(['auth:sanctum']);
