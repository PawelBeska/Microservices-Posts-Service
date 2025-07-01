<?php

namespace App\External\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        try {
            $user = User::make(auth()->payload()['user']);

            Auth::setUser($user);

            return $next($request);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
