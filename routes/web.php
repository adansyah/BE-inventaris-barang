<?php

use App\Http\Controllers\KIRController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;



Route::get('/', [KIRController::class, 'tes']);
Route::get('/laporan-barang', [LaporanController::class, 'index']);
Route::get('/kondisi-barang', [LaporanController::class, 'kondisi']);
Route::get('/kondisi-barang-baik', [LaporanController::class, 'kondisi_baik']);
Route::get('/kondisi-barang-rusak', [LaporanController::class, 'kondisi_rusak']);
