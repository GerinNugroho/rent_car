<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
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

// Definisi/Membuat route CRUD users dengan apiResource

Route::post('register', [UserController::class, 'store']);

Route::post('login', [AuthenticationController::class, 'login']);

Route::get('logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::get('profile', [AuthenticationController::class, 'profile'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
 Route::apiResource('categories', CategoryController::class)->only('index');
 Route::apiResource('admin/categories', CategoryController::class)->only(['store', 'update', 'destroy']);
 Route::apiResource('admin/cars', CarController::class)->only(['store', 'update', 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:customer'])->group(function () {
 Route::apiResource('bookings', BookingController::class)->only(['store', 'index']);
});



Route::apiResource('cars', CarController::class)->only(['index', 'show']);
