<?php

namespace App\Repositories;

use App\Models\BorrowerDoc;
use Prettus\Repository\Eloquent\BaseRepository;

class BorrowerDocRepository extends BaseRepository
{
    public function model(): string
    {
        return BorrowerDoc::class;
    }
}
