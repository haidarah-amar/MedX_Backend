<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ClinicContract;
use App\Repositories\ClinicRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
        ClinicContract::class,
        ClinicRepository::class
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
