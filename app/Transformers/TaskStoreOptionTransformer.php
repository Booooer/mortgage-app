<?php

namespace App\Transformers;

use App\Models\Task;
use League\Fractal\TransformerAbstract;

class TaskStoreOptionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Task $task): array
    {
        return [
            'deal_id'           => $task->deal_id,
            'task_type'         => $task->type,
            'wished_sum'        => $task->wished_sum,
            'have_init_payment' => $task->have_init_payment,
            'init_payment'      => $task->init_payment,
            'maternity_capital' => $task->maternity_capital,
            'author_id'         => $task->author_id,
            'comment'           => $task->comment,
            'created_at'        => $task->created_at,
        ];
    }
}
