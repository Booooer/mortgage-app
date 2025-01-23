<?php

namespace App\Http\Controllers;

use App\Services\Task\MaritalStatusService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaritalStatusController extends Controller
{
    public function __construct(
        private readonly MaritalStatusService $service
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
