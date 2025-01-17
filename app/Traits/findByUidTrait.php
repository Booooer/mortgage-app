<?php

namespace App\Traits;

trait findByUidTrait
{
    public function findByUid(string $uid, $repository)
    {
        return $repository->findByField('uid', $uid)->firstOrFail();
    }
}
