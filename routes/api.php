<?php

use App\Http\Controllers\ClinicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('clinics/management')->group(function () {

    Route::post('/register', [ClinicController::class, 'store']);
    Route::post('/login', [ClinicController::class, 'login']);

    Route::middleware('auth:api')->group(function () {

        Route::get('/logout', [ClinicController::class, 'logout']);
        Route::get('/show', [ClinicController::class, 'show']);
        Route::post('/update', [ClinicController::class, 'update']);
        Route::post('/activate', [ClinicController::class, 'activate']);
        Route::post('/upload_images', [ClinicController::class, 'uploadImage']);
    });
});
