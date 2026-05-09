<?php

use App\Http\Controllers\ClinicControllers\ClinicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClinicControllers\DepartmentController;
use App\Http\Controllers\ClinicControllers\DoctorController;

// User Auth
Route::prefix('auth')->group(function () {
Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix('profile')->middleware('auth:api')->group(function () {

    // Auth
    Route::post('logout',         [AuthController::class, 'logout']);
    Route::get('/',         [AuthController::class, 'profile']);
    Route::post('/update',         [AuthController::class, 'updateProfile']);
});

Route::prefix('clinics/management')->group(function () {

    Route::post('/register', [ClinicController::class, 'store']);
    Route::post('/login', [ClinicController::class, 'login']);

    Route::middleware('auth:clinic-api')->group(function () {

        Route::get('/logout', [ClinicController::class, 'logout']);
        Route::get('/show', [ClinicController::class, 'show']);
        Route::post('/update', [ClinicController::class, 'update']);
        Route::post('/activate', [ClinicController::class, 'activate']);
        Route::post('/upload_images', [ClinicController::class, 'uploadImage']);
    });
});

Route::prefix('clinics/departments')->controller(DepartmentController::class)->group(function () {

    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{id}', 'show');
    Route::post('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::prefix('clinics/doctors')->controller(DoctorController::class)->group(function () {

    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/serial/{serial}', 'findBySerial');
    Route::get('/contracted', 'clinicDoctors');
    Route::post('/contract', 'contract');
    Route::post('/uncontract', 'uncontract');
    Route::get('/{id}', 'show');
    Route::post('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});