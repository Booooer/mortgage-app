<?php

namespace App\Repositories;

use App\Models\Bank;
use Prettus\Repository\Eloquent\BaseRepository;

class BankRepository extends BaseRepository
{
    public function model(): string
    {
        return Bank::class;
    }
}
