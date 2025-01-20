<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Services\B24\B24TaskService;
use App\Services\Task\TaskService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService    $service,
        private readonly B24TaskService $b24TaskService
    ) {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Exception
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->service->createTask($request);

        if ($task) {
            $this->b24TaskService->createTask($request);
        }

        return response()->json($task);
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
