<?php

namespace App\Http\Controllers;

use App\Services\Task\LiveComplexService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LiveComplexController extends Controller
{
    public function __construct(
        private readonly LiveComplexService $service
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
