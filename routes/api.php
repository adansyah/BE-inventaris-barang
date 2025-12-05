<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KIBController;
use App\Http\Controllers\KIRController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/dashboard', [DashboardController::class, 'dashboard']);
Route::middleware('auth:sanctum', 'role:admin')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/kib', [KIBController::class, 'kib']);
    Route::post('/kib', [KIBController::class, 'store']);
    Route::get('/kib/{id}', [KIBController::class, 'show']);
    Route::put('/kib/{id}', [KIBController::class, 'update']);
    Route::delete('/kib/{id}', [KIBController::class, 'destroy']);

    Route::get('/user', [UserController::class, 'user']);
    Route::post('/user', [UserController::class, 'store']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    Route::get('/kir', [KIRController::class, 'kir']);
    Route::post('/kir', [KIRController::class, 'store']);
    Route::get('/kir/{id}', [KIRController::class, 'show']);
    Route::put('/kir/{id}', [KIRController::class, 'update']);
    Route::delete('/kir/{id}', [KIRController::class, 'destroy']);
    Route::post('/kir/print-label', [KirController::class, 'printLabel']);

    // Route::get('/dashboard', [DashboardController::class, 'dashboard']);
});
