<?php

namespace App\Services\Task;

use App\Http\Requests\StoreTaskRequest;
use App\Repositories\TaskBorrowerRepository;
use App\Repositories\TaskRepository;
use Clockwork\Request\Log;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Exception;

class TaskService
{
    public function __construct(
        private TaskRepository         $taskRepository,
        private TaskBorrowerRepository $taskBorrowerRepository
    ) {
    }

    public function createBorrower(StoreTaskRequest $data)
    {
    }

    /**
     * @throws Exception
     */
    public function createTask(StoreTaskRequest $data)
    {
        try {
            DB::beginTransaction();
            $borrower = $this->createBorrower($data);

            $this->taskRepository->create([
                'app_id' => auth()->user()->app_id,
            ]);

            if ($data->filled('docs')) {
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
