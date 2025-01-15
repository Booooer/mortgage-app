<?php

namespace App\Services\Auth;

use App\Data\Auth\AuthTokenData;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Tymon\JWTAuth\JWTGuard;

class JWTAuthService
{
    private JWTGuard $auth;

    public function __construct()
    {
        /** @var $auth JWTGuard */
        $auth = auth('api');
        $this->auth = $auth;
    }

    public function login(User $user): AuthTokenData
    {
        $token = $this->auth->login($user);

        return $this->getTokenData($token);
    }

    public function logout(): void
    {
        $this->auth->logout();
    }

    public function refresh(): AuthTokenData
    {
        $token = $this->auth->refresh();

        return $this->getTokenData($token);
    }

    public function getAuthUser(): Authenticatable
    {
        return $this->auth->user();
    }

    protected function getTokenData($token)
    {
        return AuthTokenData::from([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}
