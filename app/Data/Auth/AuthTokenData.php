<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class AuthTokenData extends Data
{
    public string $accessToken;

    public string $tokenType;

    public int $expiresIn;
}
