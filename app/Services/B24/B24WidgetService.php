<?php

namespace App\Services\B24;

use App\Enums\WidgetEnum;
use App\Traits\B24AppTrait;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use DomDev\B24LaravelApp\Models\B24Install;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class B24WidgetService
{
    use B24AppTrait;

    /**
     * @throws TransportException
     * @throws InvalidArgumentException
     * @throws UnknownScopeCodeException
     * @throws BaseException
     */
    public function setWidget(string $entityCode, B24Install $install): void
    {
        $this->setB24App($install);

        $response = $this->b24App->getPlacementScope()->placement()->bind(
            $entityCode,
            WidgetEnum::getHandler(),
            WidgetEnum::getWidgetConfig());

        if (!$response->isSuccess()) {
            Log::channel('b24')->debug(print_r($response->getCoreResponse()->getHttpResponse(), true));
        }
    }
}
