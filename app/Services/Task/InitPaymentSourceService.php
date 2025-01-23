<?php

namespace App\Services\Task;

use App\Repositories\InitPaymentSourceRepository;

final readonly class InitPaymentSourceService
{
    public function __construct(
        private InitPaymentSourceRepository $repository
    ) {
    }

    public function getAll()
    {
        return $this->repository->all();
    }
}
