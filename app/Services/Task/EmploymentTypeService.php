<?php

namespace App\Services\Task;

use App\Repositories\EmploymentTypeRepository;

final readonly class EmploymentTypeService
{
    public function __construct(
        private EmploymentTypeRepository $repository
    ) {
    }

    public function getAll()
    {
        return $this->repository->all();
    }
}
