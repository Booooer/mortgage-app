<?php

namespace App\Services\Task;

use App\Helpers\UidHelper;
use App\Http\Requests\StoreTaskRequest;
use App\Models\BorrowerDoc;
use App\Repositories\B24ContactRepository;
use App\Repositories\BankRepository;
use App\Repositories\BorrowerDocRepository;
use App\Repositories\EmploymentTypeRepository;
use App\Repositories\InitPaymentSourceRepository;
use App\Repositories\LiveComplexRepository;
use App\Repositories\MaritalStatusRepository;
use App\Repositories\MortgageTypeRepository;
use App\Repositories\PhoneRepository;
use App\Repositories\TaskBorrowerRepository;
use App\Repositories\TaskRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Prettus\Validator\Exceptions\ValidatorException;

readonly final class TaskService
{
    public function __construct(
        private TaskRepository         $taskRepository,
        private TaskBorrowerRepository $taskBorrowerRepository,
        private BorrowerDocRepository  $borrowerDocRepository,
        private UidHelper              $uidHelper,
    ) {
    }

    /**
     * @throws ValidatorException
     */
    public function createBorrower(StoreTaskRequest $data)
    {
        return $this->taskBorrowerRepository->create([
            'type'               => $data->get('borrower_type'),
            'employment_type_id' => $this->uidHelper->findIdByUid(
                $data->get('employment_type_uid'), EmploymentTypeRepository::class),
            'bank_id'            => $this->uidHelper->findIdByUid($data->get('bank_uid'), BankRepository::class),
            'marital_status_id'  => $this->uidHelper->findIdByUid(
                $data->get('marital_status_uid'), MaritalStatusRepository::class),
            'have_children'      => (bool) $data->get('have_children'),
            'contact_id'         => $this->uidHelper->findIdByUid(
                $data->get('contact_uid'), B24ContactRepository::class),
            'phone_id'           => $this->uidHelper->findIdByUid($data->get('phone_uid'), PhoneRepository::class),
        ]);
    }

    /**
     * @throws Exception
     */
    public function createTask(StoreTaskRequest $data)
    {
        try {
            DB::beginTransaction();
            $borrower = $this->createBorrower($data);

            $task = $this->taskRepository->create([
                'app_id'                 => auth()->user()->app_id,
                'deal_id'                => $data->get('deal_id'),
                'type'                   => $data->get('task_type'),
                'wished_sum'             => $data->get('wished_sum'),
                'have_init_payment'      => $data->get('have_init_payment'),
                'init_payment'           => $data->filled('init_payment') ? $data->get('init_payment') : null,
                'maternity_capital'      => $data->filled('maternity_capital')
                    ? $data->get('maternity_capital')
                    : null,
                'init_payment_source_id' => $data->filled('init_payment_source_uid')
                    ? $this->uidHelper->findIdByUid($data->get('init_payment_source_uid'), InitPaymentSourceRepository::class)
                    : null,
                'mortgage_type_id'       => $this->uidHelper->findIdByUid(
                    $data->get('mortgage_type_uid'), MortgageTypeRepository::class),
                'live_complex_id'        => $this->uidHelper->findIdByUid(
                    $data->get('live_complex_uid'), LiveComplexRepository::class),
                'borrower_id'            => $borrower->id,
                'author_id'              => auth()->user()->id,
                'comment'                => $data->filled('comment') ? $data->get('comment') : null,
            ]);

            if ($data->hasFile('docs')) {
                $this->attachDocs($borrower->id, $data->allFiles());
            }
            DB::commit();

            return $task;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws ValidatorException
     */
    public function attachDocs(int $borrowerId, array $docs): void
    {
        foreach ($docs as $document) {
            $randFileName = Str::random() . '.' . $document->extension();

            if (! Storage::exists($randFileName) && Storage::putFileAs('public', $document, $randFileName)) {
                $this->borrowerDocRepository->create([
                    'file'        => $randFileName,
                    'borrower_id' => $borrowerId,
                ]);
            } else {
                throw new ValidatorException(['file' => 'Error while uploading file']);
            }
        }
    }
}
