<?php

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

Route::get('/transaksi', [App\Http\Controllers\TransaksiController::class, 'index']);
Route::post('/transaksi', [App\Http\Controllers\TransaksiController::class, 'store']);
Route::get('/transaksi/{id}', [App\Http\Controllers\TransaksiController::class, 'show']);
Route::post('/transaksi/update/{id}', [App\Http\Controllers\TransaksiController::class, 'update']);
Route::post('/transaksi/delete/{id}', [App\Http\Controllers\TransaksiController::class, 'destroy']);
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');