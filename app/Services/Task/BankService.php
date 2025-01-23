<?php

namespace App\Services\Task;

use App\Repositories\BankRepository;

final readonly class BankService
{
    public function __construct(
        private BankRepository $repository
    ) {
    }

    public function getAll()
    {
        return $this->repository->all();
    }
}
