<?php

namespace App\Services\Task;

use App\Repositories\MortgageTypeRepository;

final readonly class MortgageTypeService
{
    public function __construct(
        private MortgageTypeRepository $repository
    ) {
    }

    public function getAll()
    {
        return $this->repository->all();
    }
}
