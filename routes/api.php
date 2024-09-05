<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::controller(AuthController::class)->group(function () {
    Route::post("login", "login");
    Route::post("register", "register");
    Route::get("logout", "logout")->middleware("auth:sanctum");
});

Route::apiResource('posts', PostController::class);
Route::apiResource('comments', CommentController::class)->middleware("auth:sanctum");

Route::controller(PostLikeController::class)->group(function () {
    Route::get("getAllLikesPosts", "getAllLikesPosts");
    Route::get("getAllDislikesPosts", "getAllDislikesPosts");

    Route::get("getLikesForUser/{user}", "getLikesForUser");
    Route::get("getDislikesForUser/{user}", "getDislikesForUser");

    Route::get("getLikesForPost/{post}", "getLikesForPost");
    Route::get("getDislikesForPost/{post}", "getDislikesForPost");
});
