<?php

namespace App\Repositories;

use App\Models\MaritalStatus;
use Prettus\Repository\Eloquent\BaseRepository;

class MaritalStatusRepository extends BaseRepository
{
    public function model(): string
    {
        return MaritalStatus::class;
    }
}
