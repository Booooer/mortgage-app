<?php

namespace App\Repositories;

use App\Models\Task;
use Prettus\Repository\Eloquent\BaseRepository;

class TaskRepository extends BaseRepository
{
    public function model(): string
    {
        return Task::class;
    }
}
