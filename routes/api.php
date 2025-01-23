<?php

use App\Http\Controllers\Auth\JWTController;
use App\Http\Controllers\B24ContactController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BitrixController;
use App\Http\Controllers\EmploymentTypeController;
use App\Http\Controllers\InitPaymentSourceController;
use App\Http\Controllers\LiveComplexController;
use App\Http\Controllers\MaritalStatusController;
use App\Http\Controllers\MortgageTypeController;
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
        Route::apiResource('task', TaskController::class)
            ->only('store', 'update', 'index');
        Route::apiResource('contact', B24ContactController::class)
            ->only('index');
        Route::apiResource('live-complex', LiveComplexController::class)
            ->only('index');
        Route::apiResource('mortgage-type', MortgageTypeController::class)
            ->only('index');
        Route::apiResource('bank', BankController::class)
            ->only('index');
        Route::apiResource('employment-type', EmploymentTypeController::class)
            ->only('index');
        Route::apiResource('init-payment-source', InitPaymentSourceController::class)
            ->only('index');
        Route::apiResource('marital-status', MaritalStatusController::class)
            ->only('index');
    });

    // установка приложения в crm битрикс24
    Route::match(['get', 'post'], 'b24/install', [BitrixController::class, 'b24Install']);
});

Route::fallback(static function () {
    return response()->json([
        'message' => 'Think about what you are doing, because you are clearly doing something wrong...',
        'errors'  => ['error' => 'Route not found'],
    ], 404);
});
