<?php

namespace App\Repositories;

use App\Models\InitPaymentSource;
use Prettus\Repository\Eloquent\BaseRepository;

class InitPaymentSourceRepository extends BaseRepository
{
    public function model(): string
    {
        return InitPaymentSource::class;
    }
}
