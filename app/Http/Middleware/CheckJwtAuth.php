<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class CheckJwtAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! is_null(JWTAuth::getToken()) && JWTAuth::parseToken()->getPayload()->get('sub')) {
            JWTAuth::authenticate();
        }

        return $next($request);
    }
}
