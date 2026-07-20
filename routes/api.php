<?php

use App\Http\Controllers\AdminControllers\SuperAdminController;
use App\Http\Controllers\ClinicControllers\ClinicController;
use App\Http\Controllers\ClinicControllers\DepartmentController;
use App\Http\Controllers\ClinicControllers\DoctorController;
use App\Http\Controllers\ClinicControllers\DocumentController;
use App\Http\Controllers\FinancialControllers\FinancialDashboardController;
use App\Http\Controllers\FinancialControllers\FinancialExportController;
use App\Http\Controllers\FinancialControllers\FinancialTrendController;
use App\Http\Controllers\FinancialControllers\OperationalExpenseController;
use App\Http\Controllers\UserControllers\AppointmentController;
use App\Http\Controllers\UserControllers\AuthController;
use App\Http\Controllers\UserControllers\FcmTokenController;
use App\Http\Controllers\UserControllers\NotificationController;
use Illuminate\Support\Facades\Route;

// User Auth
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('profile')->middleware('auth:api')->group(function () {

    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/', [AuthController::class, 'profile']);
    Route::post('/update', [AuthController::class, 'updateProfile']);

    // Appointments
    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::get('appointments/{appointment}', [AppointmentController::class, 'show']);
    Route::post('appointments', [AppointmentController::class, 'store']);
    Route::patch('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel']);
    Route::patch('appointments/{appointment}/complete', [AppointmentController::class, 'complete']);
    Route::put('appointments/{appointment}', [AppointmentController::class, 'update']);

    // Firebase notifications
    Route::post('fcm-tokens', [FcmTokenController::class, 'store']);
    Route::delete('fcm-tokens', [FcmTokenController::class, 'destroy']);
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::get('notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::patch('notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
    Route::patch('notifications/read-all', [NotificationController::class, 'markAllAsRead']);
});

Route::prefix('admin')->group(function () {
    Route::post('login', [SuperAdminController::class, 'login']);

    Route::middleware(['auth:api', 'super.admin'])->group(function () {
        Route::get('clinics', [SuperAdminController::class, 'clinics']);
        Route::patch('clinics/{clinicId}/approve', [SuperAdminController::class, 'approveClinic']);
        Route::patch('clinics/{clinicId}/reject', [SuperAdminController::class, 'rejectClinic']);
        Route::patch('clinics/{clinicId}/stop', [SuperAdminController::class, 'stopClinic']);
        Route::patch('clinics/{clinicId}/start', [SuperAdminController::class, 'startClinic']);
    });
});

Route::prefix('clinics/management')->group(function () {

    Route::post('/register', [ClinicController::class, 'store']);
    Route::post('/login', [ClinicController::class, 'login']);
    Route::get('/', [ClinicController::class, 'index']);

    Route::middleware('auth:clinic-api')->group(function () {

        Route::get('/logout', [ClinicController::class, 'logout']);
        Route::get('/show', [ClinicController::class, 'show']);


        Route::middleware('clinic.working')->group(function () {
            Route::post('/update', [ClinicController::class, 'update']);
            Route::post('/activate', [ClinicController::class, 'activate']);
            Route::post('/upload_images', [ClinicController::class, 'uploadImage']);
        });
    });
});

Route::prefix('clinics/departments')->controller(DepartmentController::class)->group(function () {

    Route::get('/{clinicId}', 'index');
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
    Route::get('/department/{departmentId}', 'getDoctorsByDepartment');
    Route::post('/contract', 'contract');
    Route::post('/update_hourly_rate', 'updateHourlyRate');
    Route::post('/uncontract', 'uncontract');
    Route::get('/{id}', 'show');
    Route::post('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::prefix('financial/expenses')
    ->controller(OperationalExpenseController::class)
    ->group(function () {

        Route::get('/', 'index');

        Route::post('/', 'store');

        Route::get('/{operationalExpense}', 'show');

        Route::put('/{operationalExpense}', 'update');

        Route::delete('/{operationalExpense}', 'destroy');
    });

Route::prefix('clinic/document')
    ->controller(DocumentController::class)
    ->middleware('auth:clinic-api')
    ->group(function () {

        Route::get('/', 'index');

        Route::post('/', 'store');

        Route::get('/{id}', 'show');

        Route::post('/{id}', 'update');

        Route::delete('/{id}', 'destroy');
    });

Route::prefix('financial/trends')
    ->controller(FinancialTrendController::class)
    ->group(function () {

        Route::get('/revenue', 'revenue');

        Route::get('/doctor-cost', 'doctorCost');

        Route::get('/expenses', 'expenses');

        Route::get('/profit', 'profit');
    });

Route::prefix('financial/dashboard')
    ->controller(FinancialDashboardController::class)
    ->group(function () {

        Route::get('/summary', 'summary');

        Route::get('/patient-inflow', 'patientInflow');

        Route::get('/appointment-status', 'appointmentStatus');

        Route::get('/departments', 'departments');
    });

Route::get('/financial/export', [FinancialExportController::class, 'export']);

Route::prefix('favorites')->group(function () {
    Route::post('/toggle/{clinicId}', [\App\Http\Controllers\FavoriteController::class, 'toggle']);
    Route::get('/', [\App\Http\Controllers\FavoriteController::class, 'getAllFavoritesByUserId']);
});
