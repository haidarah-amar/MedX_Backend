<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ClinicRepository;
use App\Repositories\Contracts\ClinicRepositoryInterface;
use App\Services\ClinicService;
use App\Services\Contracts\ClinicServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ClinicRepositoryInterface::class,
            ClinicRepository::class
        );

        $this->app->bind(
            ClinicServiceInterface::class,
            ClinicService::class
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
