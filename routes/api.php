<?php

use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', Api\UserController::class);
Route::apiResource('posts', Api\PostController::class);
Route::apiResource('comments', Api\CommentController::class);

// дополнительные:
Route::get('users/{user}/posts', [Api\UserController::class, 'posts']);
Route::get('users/{user}/comments', [Api\UserController::class, 'comments']);
Route::get('posts/{post}/comments', [Api\PostController::class, 'comments']);
