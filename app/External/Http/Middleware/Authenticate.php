<?php

namespace App\External\Http\Middleware;

use App\Enums\ResponseCodeEnum;
use App\Models\User;
use App\Traits\ApiResponse;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Authenticate
{
    use ApiResponse;

    public function handle(Request $request, Closure $next)
    {
        try {
            if ($request->bearerToken() || !Auth::user()) {
                $user = User::make(auth()->payload()['user']);

                Auth::setUser($user);
            }

            return $next($request);
        } catch (JWTException) {
            return $this->codeResponse(ResponseCodeEnum::UNAUTHORIZED);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
