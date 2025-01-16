<?php

namespace App\Repositories;

use App\Models\MortgageType;
use Prettus\Repository\Eloquent\BaseRepository;

class MortgageTypeRepository extends BaseRepository
{
    public function model(): string
    {
        return MortgageType::class;
    }
}
