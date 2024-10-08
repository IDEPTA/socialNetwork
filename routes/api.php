<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\ChatShowController;
use App\Http\Controllers\EmailNotificationController;
use App\Http\Controllers\Like\PostLikeController;
use App\Http\Controllers\Like\PostLikeShowController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Message\MessageShowController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::controller(AuthController::class)->group(function () {
    Route::post("login", "login");
    Route::post("register", "register");
    Route::get("logout", "logout")->middleware("auth:sanctum");
});

Route::apiResource('posts', PostController::class);
Route::apiResource('comments', CommentController::class);
Route::apiResource('chats', ChatController::class);
Route::apiResource('messages', MessageController::class);
Route::apiResource("postLikes", PostLikeController::class);

Route::controller(PostLikeShowController::class)->group(function () {
    Route::get("getLikesForUser/{user}", "getLikesForUser");
    Route::get("getDislikesForUser/{user}", "getDislikesForUser");

    Route::get("getLikesForPost/{post}", "getLikesForPost");
    Route::get("getDislikesForPost/{post}", "getDislikesForPost");
});

Route::controller(ChatShowController::class)->group(function () {
    Route::get("getChatsForUser/{user}", "getChatsForUser");
});

Route::controller(MessageShowController::class)->group(function () {
    Route::get("getMessageForChat/{chat}", "getMessageForChat");
});

Route::post("sendEmailNotifications", EmailNotificationController::class);
