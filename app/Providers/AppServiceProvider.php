<?php

namespace App\Providers;

use App\Interfaces\Auth\AuthServicesInterface;
use App\Services\Auth\AuthServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServicesInterface::class, AuthServices::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
