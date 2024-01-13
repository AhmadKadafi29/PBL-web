<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriobatController;
use App\Http\Controllers\Api\ObatController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\DashboardController;


use App\Http\Controllers\supplierController;
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
Route::get('/kategori_obat', [KategoriobatController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/obat', [ObatController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth:sanctum']);
Route::resource('/supplier', supplierController::class)->middleware(['auth:sanctum']);
Route::get('/obat_kadaluara', [ObatController::class, 'kadaluarsa'])->middleware(['auth:sanctum']);

Route::get('/user', [UserController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/user/create', [UserController::class, 'store'])->middleware(['auth:sanctum']);
Route::put('/user/update/{id}', [UserController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/user', [UserController::class, 'delete'])->middleware(['auth:sanctum']);

Route::get('/profile', [ProfileController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/profile/updatepassword', [ProfileController::class, 'updatePassword'])->middleware(['auth:sanctum']);
