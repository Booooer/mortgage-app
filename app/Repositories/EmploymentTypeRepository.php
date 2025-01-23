<?php

namespace App\Repositories;

use App\Models\Bank;
use App\Models\EmploymentType;
use Prettus\Repository\Eloquent\BaseRepository;

class EmploymentTypeRepository extends BaseRepository
{
    public function model(): string
    {
        return EmploymentType::class;
    }
}
