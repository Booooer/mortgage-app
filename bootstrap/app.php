<?php

use App\Http\Middleware\AutoLogin;
use App\Http\Middleware\CheckJwtAuth;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\ValidateSignature;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

$application = Application::configure()
    ->withProviders()
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            TrustProxies::class,
            HandleCors::class,
            PreventRequestsDuringMaintenance::class,
            ValidatePostSize::class,
            TrimStrings::class,
            ConvertEmptyStringsToNull::class,
        ]);

        $middleware->web(append: [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            SubstituteBindings::class,
        ], replace: [
            // Вообще, этот механизм используется для подмены стандартных миддлвейров
            // они теперь лоадятся внутри ядра фреймворка, минуя Kernel.php
            // Прочитать можно тут https://laravel.com/docs/11.x/middleware#laravels-default-middleware-groups
            // И тут https://laravel.com/docs/11.x/middleware#laravels-default-middleware-groups
        ]);

        $middleware->api(append: [
            ThrottleRequests::class . ':api',
            SubstituteBindings::class,
        ]);

        $middleware->alias([
            'auth'             => Authenticate::class,
            'auth:api'         => CheckJwtAuth::class,
            'auth.basic'       => AuthenticateWithBasicAuth::class,
            'autologin'        => AutoLogin::class,
            'cache.headers'    => SetCacheHeaders::class,
            'can'              => Authorize::class,
            'guest'            => RedirectIfAuthenticated::class,
            'password.confirm' => RequirePassword::class,
            'precognitive'     => HandlePrecognitiveRequests::class,
            'signed'           => ValidateSignature::class,
            'throttle'         => ThrottleRequests::class,
            'verified'         => EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //     // тут же регистрируем свои Exceptions, которые описаны в app/Exceptions/Handler.php
        //     $exceptions->dontReportDuplicates();
        //     $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
        //         if ($request->is('api/*')) {
        //             if ($e instanceof ValidationException) {
        //                 return response()->json([
        //                     'code'    => $e->status,
        //                     'message' => $e->getMessage(),
        //                     'errors'  => $e->errors(),
        //                 ], $e->status);
        //             }
        //
        //             if (method_exists($e, 'getStatusCode') && $e->getStatusCode() != 0) {
        //                 $statusCode = $e->getStatusCode();
        //             } elseif (method_exists($e, 'getCode') && $e->getCode() != 0) {
        //                 $statusCode = $e->getCode();
        //             } else {
        //                 $statusCode = 404;
        //             }
        //
        //             return response()->json(['code' => $statusCode, 'message' => $e->getMessage()], $statusCode);
        //         } else {
        //             return $request->expectsJson();
        //         }
        //     });
    })
    ->withCommands([
        __DIR__ . '/../app/Console/Commands',
    ])
    ->create();

return $application;
