<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Services\B24\B24ContactService;
use App\Services\B24\B24TaskService;
use App\Services\Task\TaskService;
use App\Transformers\TaskStoreOptionTransformer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService       $service,
        private readonly B24TaskService    $b24TaskService,
        private readonly B24ContactService $b24ContactService
    ) {
    }

    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Exception
     */
    public function store(StoreTaskRequest $request): array
    {
        $task = $this->service->createTask($request);

        if ($task) {
            $this->b24TaskService->createTask($request);
            $this->b24ContactService->updateContact($request);
        }

        return $this->transform($task, TaskStoreOptionTransformer::class);
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
