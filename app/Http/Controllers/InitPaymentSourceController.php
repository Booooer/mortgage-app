<?php

namespace App\Http\Controllers;

use App\Services\Task\InitPaymentSourceService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InitPaymentSourceController extends Controller
{
    public function __construct(
        private readonly InitPaymentSourceService $service
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        return new ResourceCollection($this->service->getAll());
    }
}
