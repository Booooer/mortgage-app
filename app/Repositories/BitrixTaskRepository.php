<?php

namespace App\Repositories;

use App\Models\BitrixTask;
use Prettus\Repository\Eloquent\BaseRepository;

class BitrixTaskRepository extends BaseRepository
{
    public function model(): string
    {
        return BitrixTask::class;
    }
}
