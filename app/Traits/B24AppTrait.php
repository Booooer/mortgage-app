<?php

namespace App\Traits;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use DomDev\B24LaravelApp\Models\B24Install;
use DomDev\B24LaravelApp\Services\B24ApiService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

trait B24AppTrait
{
    protected B24ApiService $b24App;

    protected Authenticatable $user;

    /**
     * @throws UnknownScopeCodeException
     * @throws InvalidArgumentException
     */
    protected function setB24App(B24Install $install = null): void
    {
        $this->user = Auth::user();
        $this->b24App = B24ApiService::fromInstall($install ?? $this->user->install);
    }
}
