<?php

namespace App\Http\Controllers;

use App\Enums\WidgetEnum;
use App\Services\B24\B24InstallService;
use App\Services\B24\B24WidgetService;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use DomDev\B24LaravelApp\Data\B24InstallData;
use DomDev\B24LaravelApp\Requests\B24InstallWebhookRequest;
use Illuminate\View\View;

class BitrixController extends Controller
{
    public function __construct(
        private B24InstallService $service,
        private B24WidgetService  $widgetService
    ) {
    }

    /**
     * @throws TransportException
     * @throws InvalidArgumentException
     * @throws UnknownScopeCodeException
     * @throws BaseException
     */
    public function b24Install(B24InstallWebhookRequest $request): View
    {
        $installData = B24InstallData::from($request->validated());

        $installed = $this->service->install($installData);

        if ($installed) {
            $this->widgetService->setWidget(WidgetEnum::DEAL_CODE->value, $installed);
            $this->widgetService->setWidget(WidgetEnum::TASK_CODE->value, $installed);
        }

        return view('b24.install', (bool) compact('installed'));
    }
}


