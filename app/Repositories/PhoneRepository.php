<?php

namespace App\Repositories;

use App\Models\Phone;
use Prettus\Repository\Eloquent\BaseRepository;

class PhoneRepository extends BaseRepository
{
    public function model(): string
    {
        return Phone::class;
    }
}
