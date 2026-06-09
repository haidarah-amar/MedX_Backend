<?php

namespace App\Providers;

use App\Repositories\Contracts\OperationalExpenseRepositoryInterface;
use Illuminate\Support\ServiceProvider;

// Clinic
use App\Repositories\ClinicRepository;
use App\Repositories\Contracts\ClinicRepositoryInterface;
use App\Services\ClinicService;
use App\Services\Contracts\ClinicServiceInterface;

// Department
use App\Repositories\DepartmentRepository;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Services\DepartmentService;
use App\Services\Contracts\DepartmentServiceInterface;

// Doctor
use App\Repositories\DoctorRepository;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Services\DoctorService;
use App\Services\Contracts\DoctorServiceInterface;

// Appointment
use App\Repositories\AppointmentRepository;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Repositories\Contracts\FinancialAnalyticsRepositoryInterface;
use App\Services\AppointmentService;
use App\Services\Contracts\AppointmentServiceInterface;

// User
use App\Repositories\UserRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\FinancialAnalyticsRepository;
use App\Repositories\OperationalExpenseRepository;
use App\Services\Contracts\FinancialAnalyticsServiceInterface;
use App\Services\Contracts\OperationalExpenseServiceInterface;
use App\Services\UserService;
use App\Services\Contracts\UserServiceInterface;
use App\Services\FinancialAnalyticsService;
use App\Services\OperationalExpenseService;
use FinancialAnalyticsRepository as GlobalFinancialAnalyticsRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Clinic Bindings
        $this->app->bind(
            ClinicRepositoryInterface::class,
            ClinicRepository::class
        );

        $this->app->bind(
            ClinicServiceInterface::class,
            ClinicService::class
        );

        // Department Bindings
        $this->app->bind(
            DepartmentRepositoryInterface::class,
            DepartmentRepository::class
        );

        $this->app->bind(
            DepartmentServiceInterface::class,
            DepartmentService::class
        );

        // Doctor Bindings
        $this->app->bind(
            DoctorRepositoryInterface::class,
            DoctorRepository::class
        );

        $this->app->bind(
            DoctorServiceInterface::class,
            DoctorService::class
        );

        // Appointment Bindings
        $this->app->bind(
            AppointmentRepositoryInterface::class,
            AppointmentRepository::class
        );

        $this->app->bind(
            AppointmentServiceInterface::class,
            AppointmentService::class
        );

        // User Bindings
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );

        $this->app->bind(
            FinancialAnalyticsRepositoryInterface::class,
            FinancialAnalyticsRepository::class
);

        $this->app->bind(
            FinancialAnalyticsServiceInterface::class,
            FinancialAnalyticsService::class
);

$this->app->bind(
    OperationalExpenseRepositoryInterface::class,
    OperationalExpenseRepository::class
);

$this->app->bind(
    OperationalExpenseServiceInterface::class,
    OperationalExpenseService::class
);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
