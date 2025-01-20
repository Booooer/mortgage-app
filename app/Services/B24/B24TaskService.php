<?php

namespace App\Services\B24;

use App\Http\Requests\StoreTaskRequest;
use App\Repositories\B24InstallRepository;
use App\Repositories\B24TaskGroupRepository;
use App\Repositories\MortgageTypeRepository;
use App\Traits\findByUidTrait;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use DomDev\B24LaravelApp\Services\B24ApiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

final class B24TaskService
{
    use findByUidTrait;

    public function __construct(
        private readonly B24InstallRepository   $installRepository,
        private readonly MortgageTypeRepository $mortgageTypeRepository,
        private readonly B24TaskGroupRepository $b24TaskGroupRepository
    ) {
    }

    private function prepareTaskDescription(StoreTaskRequest $data): string
    {
        return 'test decription';
    }

    private function prepareTaskName(StoreTaskRequest $data): string
    {
        return $data->get('task_type') . '_'
            . $data->get('borrower_name') . '_'
            . $this->findByUid($data->get('mortgage_type_uid'), $this->mortgageTypeRepository)['title'];
    }

    private function getTaskGroupInfo(int $appId)
    {
        return $this->b24TaskGroupRepository->findByField('app_id', $appId)->firstOrFail();
    }

    /**
     * @throws TransportException
     * @throws InvalidArgumentException
     * @throws UnknownScopeCodeException
     * @throws BaseException
     */
    public function createTask(StoreTaskRequest $data): void
    {
        $b24Installs = $this->installRepository->all();

        foreach ($b24Installs as $b24InstallItem) {
            $b24App = B24ApiService::fromInstall($b24InstallItem);
            $creator = auth()->user()->app_id === $b24InstallItem->id ? auth()->user()->bitrix_id : 1;
            $taskGroupData = $this->getTaskGroupInfo($b24InstallItem->id);

            $b24App->core->call('tasks.task.add', [
                'fields' => [
                    'TITLE'          => $this->prepareTaskName($data),
                    'CREATED_BY'     => 1,
                    'RESPONSIBLE_ID' => 1,
                    'GROUP_ID'       => $taskGroupData->group_id,
                    'STAGE_ID'       => $taskGroupData->stage_id,
                    'DESCRIPTION'    => $this->prepareTaskDescription($data),
                ],
            ]);
        }
    }
}
