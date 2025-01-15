<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::withoutGlobalScopes()->whereUid(env('AUTO_USER_UID'))->first();
        Auth::login($user);

        return $next($request);
    }
}
