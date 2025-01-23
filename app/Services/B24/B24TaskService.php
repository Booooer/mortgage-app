<?php

namespace App\Services\B24;

use App\Enums\TaskEnum;
use App\Helpers\UidHelper;
use App\Http\Requests\StoreTaskRequest;
use App\Repositories\B24InstallRepository;
use App\Repositories\B24TaskGroupRepository;
use App\Repositories\BankRepository;
use App\Repositories\EmploymentTypeRepository;
use App\Repositories\LiveComplexRepository;
use App\Repositories\MaritalStatusRepository;
use App\Repositories\MortgageTypeRepository;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use DomDev\B24LaravelApp\Services\B24ApiService;

final readonly class B24TaskService
{
    public function __construct(
        private B24InstallRepository   $installRepository,
        private B24TaskGroupRepository $b24TaskGroupRepository,
        private UidHelper              $uidHelper,
    ) {
    }

    private function prepareTaskDescription(StoreTaskRequest $data): string
    {
        return TaskEnum::getLiveComplexFieldTitle(
                $this->uidHelper->findTitleByUid($data->get('live_complex_uid'), LiveComplexRepository::class))
            . TaskEnum::getSalaryBankFieldTitle(
                $this->uidHelper->findTitleByUid($data->get('bank_uid'), BankRepository::class))
            . TaskEnum::getEmploymentTypeFieldTitle(
                $this->uidHelper->findTitleByUid($data->get('employment_type_uid'), EmploymentTypeRepository::class))
            . TaskEnum::getMaritalStatusFieldTitle(
                $this->uidHelper->findTitleByUid($data->get('marital_status_uid'), MaritalStatusRepository::class))
            . TaskEnum::getHaveChildrenFieldTitle($data->get('have_children'))
            . TaskEnum::getMortgageTypeFieldTitle(
                $this->uidHelper->findTitleByUid($data->get('mortgage_type_uid'), MortgageTypeRepository::class))
            . TaskEnum::getWishedSumFieldTitle($data->get('wished_sum'))
            . TaskEnum::getHaveInitPaymentFieldTitle($data->get('have_init_payment'));
    }

    private function prepareTaskName(StoreTaskRequest $data): string
    {
        return $data->get('task_type') . '_'
            . $data->get('borrower_name') . '_'
            . $this->uidHelper->findTitleByUid($data->get('mortgage_type_uid'), MortgageTypeRepository::class);
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
            $creatorId = auth()->user()->app_id === $b24InstallItem->id ? auth()->user()->bitrix_id : 1;
            $taskGroupData = $this->getTaskGroupInfo($b24InstallItem->id);

            $b24App->core->call('tasks.task.add', [
                'fields' => [
                    'TITLE'          => $this->prepareTaskName($data),
                    'CREATED_BY'     => $creatorId,
                    'RESPONSIBLE_ID' => $creatorId,
                    'GROUP_ID'       => $taskGroupData->group_id,
                    'STAGE_ID'       => $taskGroupData->stage_id,
                    'DESCRIPTION'    => $this->prepareTaskDescription($data),
                ],
            ]);
        }
    }
}
