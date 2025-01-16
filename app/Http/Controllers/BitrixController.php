<?php

namespace App\Http\Controllers;

use App\Services\B24\B24InstallService;
use DomDev\B24LaravelApp\Data\B24InstallData;
use DomDev\B24LaravelApp\Requests\B24InstallWebhookRequest;
use Illuminate\View\View;

class BitrixController extends Controller
{
    public function __construct(
        private readonly B24InstallService $service,
    ) {
    }

    public function b24Install(B24InstallWebhookRequest $request): View
    {
        $installData = B24InstallData::from($request->validated());

        $installed = $this->service->install($installData);

        return view('b24.install', compact('installed'));
    }
}


