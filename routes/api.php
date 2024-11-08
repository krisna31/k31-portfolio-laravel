<?php

use App\Http\Controllers\Api\AbsenController;
use App\Http\Controllers\Api\AttendeStatusController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
// use App\Http\Controllers\Api\

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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', [AuthController::class, 'getCurrentUser']);
    Route::delete('/logout', [AuthController::class, 'logout']);

    Route::get('/absen', [AbsenController::class, 'index']);
    Route::post('/absen', [AbsenController::class, 'store']);
    Route::post('/riwayat/absen', [AbsenController::class, 'storeRiwayatPresensi']);
    Route::get('/riwayat/absen', [AbsenController::class, 'getAbsenHistory']);

    Route::get('/attende-status', [AttendeStatusController::class, 'index']);
});
