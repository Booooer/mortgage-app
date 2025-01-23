<?php

namespace App\Http\Controllers;

use App\Services\Task\EmploymentTypeService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmploymentTypeController extends Controller
{
    public function __construct(
        private readonly EmploymentTypeService $service
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
