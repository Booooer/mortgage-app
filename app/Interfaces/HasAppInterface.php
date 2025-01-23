<?php

namespace App\Interfaces;

interface HasAppInterface
{
    public static function getAppAttr(): string;

    public function app();
}
