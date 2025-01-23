<?php

namespace App\Http\Controllers;

use App\Services\Task\MortgageTypeService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MortgageTypeController extends Controller
{
    public function __construct(
        private readonly MortgageTypeService $service
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
