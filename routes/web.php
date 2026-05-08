<?php

use App\Http\Controllers\ClinicControllers\ClinicController;
use Illuminate\Support\Facades\Route;

Route::prefix('clinics')->group(function () {

    Route::post('/register', [ClinicController::class, 'store']);
    Route::post('/login', [ClinicController::class, 'login']);

    Route::middleware('auth:api')->group(function () {

        Route::post('/logout', [ClinicController::class, 'logout']);
        Route::get('/me', [ClinicController::class, 'show']);
        Route::post('/update', [ClinicController::class, 'update']);
        Route::post('/activate', [ClinicController::class, 'activate']);
        Route::post('/upload-images', [ClinicController::class, 'uploadImage']);
    });
});

