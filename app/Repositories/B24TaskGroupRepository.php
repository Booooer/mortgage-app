<?php

namespace App\Repositories;

use App\Models\B24TaskGroup;
use Prettus\Repository\Eloquent\BaseRepository;

class B24TaskGroupRepository extends BaseRepository
{
    public function model(): string
    {
        return B24TaskGroup::class;
    }
}
