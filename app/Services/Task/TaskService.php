<?php

namespace App\Services\Task;

use App\Http\Requests\StoreTaskRequest;
use App\Models\BorrowerDoc;
use App\Repositories\B24ContactRepository;
use App\Repositories\BorrowerDocRepository;
use App\Repositories\InitPaymentSourceRepository;
use App\Repositories\LiveComplexRepository;
use App\Repositories\MortgageTypeRepository;
use App\Repositories\PhoneRepository;
use App\Repositories\TaskBorrowerRepository;
use App\Repositories\TaskRepository;
use App\Traits\findByUidTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Exception;
use Prettus\Validator\Exceptions\ValidatorException;

readonly class TaskService
{
    use findByUidTrait;

    public function __construct(
        private TaskRepository              $taskRepository,
        private TaskBorrowerRepository      $taskBorrowerRepository,
        private B24ContactRepository        $b24ContactRepository,
        private PhoneRepository             $phoneRepository,
        private LiveComplexRepository       $liveComplexRepository,
        private MortgageTypeRepository      $mortgageTypeRepository,
        private InitPaymentSourceRepository $initPaymentSourceRepository,
        private BorrowerDocRepository       $borrowerDocRepository
    ) {
    }

    /**
     * @throws ValidatorException
     */
    public function createBorrower(StoreTaskRequest $data)
    {
        return $this->taskBorrowerRepository->create([
            'type'            => $data->get('borrower_type'),
            'employment_type' => $data->get('employment_type'),
            'bank_salary'     => $data->get('bank_salary'),
            'marital_status'  => $data->get('marital_status'),
            'have_children'   => $data->get('have_children'),
            'contact_id'      => $this->findByUid($data->get('contact_uid'), $this->b24ContactRepository)['id'],
            'phone_id'        => $this->findByUid($data->get('phone_uid'), $this->phoneRepository)['id'],
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
                    ? $this->findByUid($data->get('init_payment_source_uid'), $this->initPaymentSourceRepository)['id']
                    : null,
                'mortgage_type_id'       => $this->findByUid(
                    $data->get('mortgage_type_uid'), $this->mortgageTypeRepository)['id'],
                'live_complex_id'        => $this->findByUid(
                    $data->get('live_complex_uid'), $this->liveComplexRepository)['id'],
                'borrower_id'            => $borrower['id'],
                'author_id'              => auth()->user()->id,
                'comment'                => $data->filled('comment') ? $data->get('comment') : null,
            ]);

            if ($data->hasFile('docs')) {
                $this->attachDocs(7, $data->allFiles());
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
            }
        }
    }
}
