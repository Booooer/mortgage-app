<?php

use App\Http\Controllers\Auth\JWTController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    $authMiddleware = env('APP_ENV') === 'local' ? 'autologin' : 'auth:api';

    Route::prefix('auth/jwt')
        ->controller(JWTController::class)
        ->group(function () use ($authMiddleware) {
            Route::post('token', 'token')->name('jwt.token');
            Route::middleware($authMiddleware)->group(function () {
                Route::post('refresh', 'refresh')->name('jwt.refresh');
                Route::post('logout', 'logout')->name('jwt.logout');
            });
        });

    Route::middleware($authMiddleware)->group(function () {
        Route::apiResource('task', TaskController::class);
    });
});

Route::fallback(static function () {
    return response()->json([
        'message' => 'Think about what you are doing, because you are clearly doing something wrong...',
        'errors'  => ['error' => 'Route not found'],
    ], 404);
});
