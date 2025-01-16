<?php

namespace App\Repositories;

use App\Models\LiveComplex;
use Prettus\Repository\Eloquent\BaseRepository;

class LiveComplexRepository extends BaseRepository
{
    public function model(): string
    {
        return LiveComplex::class;
    }
}
