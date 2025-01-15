<?php

namespace App\Serializers;

use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;

class PayloadSerializer extends ArraySerializer
{
    /**
     * {@inheritDoc}
     */
    public function collection(?string $resourceKey, array $data): array
    {
        return ['payload' => $data];
    }

    /**
     * {@inheritDoc}
     */
    public function item(?string $resourceKey, array $data): array
    {
        return ['payload' => $data];
    }

    /**
     * {@inheritDoc}
     */
    public function null(): ?array
    {
        return ['payload' => []];
    }
}
