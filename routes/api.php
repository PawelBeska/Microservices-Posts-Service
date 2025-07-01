<?php

use App\External\Http\Middleware\Authenticate;
use App\Http\Controllers\Api\v1\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return auth()->payload();
})->middleware(Authenticate::class);

Route::apiResource('posts', PostsController::class)
    ->middleware(Authenticate::class);
