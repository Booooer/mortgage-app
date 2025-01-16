<?php

namespace App\Repositories;

use App\Models\B24Contact;
use Prettus\Repository\Eloquent\BaseRepository;

class B24ContactRepository extends BaseRepository
{
    public function model(): string
    {
        return B24Contact::class;
    }
}
