<?php

namespace App\Services\Task;

use App\Repositories\LiveComplexRepository;

final readonly class LiveComplexService
{
    public function __construct(
        private LiveComplexRepository $repository
    ) {
    }

    public function getAll()
    {
        return $this->repository->all();
    }
}
