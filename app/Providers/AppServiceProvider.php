<?php

namespace App\Providers;

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

// User
use App\Repositories\UserRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\UserService;
use App\Services\Contracts\UserServiceInterface;

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

        // User Bindings
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
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
