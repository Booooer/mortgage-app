<?php

namespace App\Services\Task;

use App\Repositories\MaritalStatusRepository;
use App\Traits\B24AppTrait;

final class MaritalStatusService
{
    use B24AppTrait;
    public function __construct(
        private readonly MaritalStatusRepository $repository
    ) {
    }

    public function getAll()
    {
        return $this->repository->all();
    }
}
