<?php

use App\External\Http\Middleware\Authenticate;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\PostsController;
use Illuminate\Support\Facades\Route;

Route::middleware(Authenticate::class)->group(function () {
    Route::apiResource('posts', PostsController::class);

    Route::apiResource('categories', CategoryController::class);
});
