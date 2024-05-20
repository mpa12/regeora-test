<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::apiResource('patients', PatientController::class)
    ->only(['index', 'store']);
