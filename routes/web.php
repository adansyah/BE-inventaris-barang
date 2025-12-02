<?php

use App\Http\Controllers\KIRController;
use Illuminate\Support\Facades\Route;



Route::get('/', [KIRController::class, 'tes']);
