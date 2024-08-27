<?php

namespace App\Providers;

use App\Services\Post\PostService;
use App\Services\Auth\AuthServices;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Post\PostServiceInterface;
use App\Interfaces\Auth\AuthServicesInterface;
use App\Interfaces\Comment\CommentServiceInterface;
use App\Services\Comment\CommentService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServicesInterface::class, AuthServices::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
