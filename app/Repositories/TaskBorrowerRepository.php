<?php

namespace App\Repositories;

use App\Models\TaskBorrower;
use Prettus\Repository\Eloquent\BaseRepository;

class TaskBorrowerRepository extends BaseRepository
{
    public function model(): string
    {
        return TaskBorrower::class;
    }
}
