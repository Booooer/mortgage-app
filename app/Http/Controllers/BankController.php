<?php

namespace App\Http\Controllers;

use App\Services\Task\BankService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BankController extends Controller
{
    public function __construct(
        private readonly BankService $service
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
