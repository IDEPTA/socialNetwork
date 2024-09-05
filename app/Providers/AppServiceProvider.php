<?php

namespace App\Providers;

use App\Services\Post\PostService;
use App\Services\Auth\AuthServices;
use App\Services\Like\PostLikeService;
use Illuminate\Support\ServiceProvider;
use App\Services\Comment\CommentService;
use App\Interfaces\Post\PostServiceInterface;
use App\Repositories\Post\PostLikeRepository;
use App\Interfaces\Auth\AuthServicesInterface;
use App\Interfaces\Like\PostLikeServiceInterface;
use App\Interfaces\Comment\CommentServiceInterface;
use App\Interfaces\PostRepository\PostLikeShowRepositoryInterface;

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
        $this->app->bind(PostLikeShowRepositoryInterface::class, PostLikeRepository::class);
        $this->app->bind(PostLikeServiceInterface::class, PostLikeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
