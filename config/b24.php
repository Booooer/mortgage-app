<?php

return [
    'logging' => [
        'level'   => \Monolog\Level::Info,
        'model'   => \DomDev\B24LaravelApp\Models\B24InstallApiLog::class,
        'log_model_lifespan_in_days' => 3,
    ],
    'installs' => [
        'model' => \DomDev\B24LaravelApp\Models\B24Install::class
    ],
    'tokens' => [
        'refresh_token_lifespan_in_days' => 14,
    ],
    'marketplace_app' => [
        'client_id' => env('B24_CLIENT_ID'),
        'client_secret' => env('B24_CLIENT_SECRET'),
        'scopes' => ['crm'],
    ]
];