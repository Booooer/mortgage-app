<?php

use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\RepositoryServiceProvider;
use App\Providers\RouteServiceProvider;
use Spatie\Fractal\FractalServiceProvider;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    EventServiceProvider::class,
    RepositoryServiceProvider::class,
    RouteServiceProvider::class,
    FractalServiceProvider::class,
    LaravelServiceProvider::class,
];
