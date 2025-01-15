<?php

namespace App\Http\Transformers\Auth;

use App\Data\Auth\AuthTokenData;
use League\Fractal\TransformerAbstract;

class TokenTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @param AuthTokenData $data
     * @return array
     */
    public function transform(AuthTokenData $data): array
    {
        return [
            'access_token' => $data->accessToken,
            'token_type'   => $data->tokenType,
            'expires_in'   => $data->expiresIn,
        ];
    }
}
