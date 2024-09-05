<?php

namespace App\Providers;

use App\Services\Post\PostService;
use App\Services\Auth\AuthServices;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Post\PostServiceInterface;
use App\Interfaces\Auth\AuthServicesInterface;
use App\Interfaces\Comment\CommentServiceInterface;
use App\Interfaces\PostRepository\PostLikeRepositoryInterface;
use App\Repositories\Post\PostLikeRepository;
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
        $this->app->bind(PostLikeRepositoryInterface::class, PostLikeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
