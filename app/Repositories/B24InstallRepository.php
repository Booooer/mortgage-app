<?php

namespace App\Repositories;

use DomDev\B24LaravelApp\Models\B24Install;
use Prettus\Repository\Eloquent\BaseRepository;

class B24InstallRepository extends BaseRepository
{
    public function getInstall(string $domain)
    {
        return $this->model->where('domain', $domain)->first();
    }

    public function model(): string
    {
        return B24Install::class;
    }
}
