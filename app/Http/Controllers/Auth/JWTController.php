<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Transformers\Auth\TokenTransformer;
use App\Models\User;
use App\Services\Auth\JWTAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JWTController extends Controller
{
    public function __construct(
        protected ?JWTAuthService $service
    ) {
    }

    public function token(Request $request) {
        $user = User::whereUid($request->post('uid'))->firstOrFail();
        $tokenData = $this->service->login($user);

        return $this->transform($tokenData, TokenTransformer::class);
    }

    public function refresh(): array
    {
        $tokenData = $this->service->refresh();

        return $this->transform($tokenData, TokenTransformer::class);
    }

    public function logout(): JsonResponse
    {
        $this->service->logout();

        return $this->noContent();
    }
}
