<?php

use App\External\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return auth()->payload();
})->middleware(Authenticate::class);
