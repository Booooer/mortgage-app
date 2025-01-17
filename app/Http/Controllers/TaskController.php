<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Services\Task\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use phpDocumentor\Reflection\Exception;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $service
    ) {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Exception
     */
    public function store(StoreTaskRequest $request): ResourceCollection
    {
        return new ResourceCollection($this->service->createTask($request));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
