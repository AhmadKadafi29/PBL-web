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

