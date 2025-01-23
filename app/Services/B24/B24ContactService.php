<?php

namespace App\Services\B24;

use App\Helpers\UidHelper;
use App\Http\Requests\StoreTaskRequest;
use App\Models\B24Contact;
use App\Repositories\B24ContactRepository;
use App\Repositories\PhoneRepository;
use App\Traits\B24AppTrait;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use Exception;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

final class B24ContactService
{
    use B24AppTrait;

    private const CONTACT_SELECT_FIELDS = [
        'PHONE',
        'NAME',
        'LAST_NAME',
        'SECOND_NAME',
    ];

    public function __construct(
        private readonly UidHelper            $uidHelper,
        private readonly B24ContactRepository $contactRepository,
        private readonly PhoneRepository      $phoneRepository
    ) {
    }

    public function formatPhoneNumber(string $phoneNumber): string
    {
        // Удаляем все символы, кроме цифр
        return preg_replace(pattern: '/[^0-9]/', replacement: '', subject: $phoneNumber);
    }

    public function getActualContacts(array $contactIds): array
    {
        return array_map(function ($contactId) {
            return B24Contact::where('bitrix_id', $contactId)->with(['phones'])->first();
        }, $contactIds);
    }

    /**
     * @throws UnknownScopeCodeException
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function updateContact(StoreTaskRequest $data): void
    {
        $this->setB24App();

        try {
            $this->b24App->getCRMScope()->contact()->update(
                $this->uidHelper->findByUid($data->get('contact_uid'), B24ContactRepository::class)->bitrix_id,
                [
                    'NAME'        => $data->get('borrower_name'),
                    'LAST_NAME'   => $data->get('borrower_surname'),
                    'SECOND_NAME' => $data->get('borrower_last_name'),
                ]
            );
        } catch (TransportException|BaseException $e) {
            throw new Exception($e->getMessage);
        }
    }

    /**
     * @throws InvalidArgumentException
     * @throws UnknownScopeCodeException
     * @throws BaseException
     */
    public function synchronizeContactsData(array $contactIds): void
    {
        $this->setB24App();

        try {
            $contactData = $this->b24App->getCRMScope()->contact()->list([], [
                'ID' => $contactIds,
            ], self::CONTACT_SELECT_FIELDS, 0)->getContacts();

            DB::beginTransaction();
            $contacts = $this->synchronizeContacts($contactData);
            $this->synchronizePhones($contacts);
            DB::commit();
        } catch (BaseException|ValidatorException $e) {
            DB::rollback();
            throw new BaseException($e->getMessage);
        }
    }

    /**
     * @throws ValidatorException
     */
    private function synchronizeContacts(array $contactsData): array
    {
        $contacts = [];

        foreach ($contactsData as $index => $contactItem) {
            $contacts[$index]['phones'] = $contactItem->PHONE;
            $result = $this->contactRepository->updateOrCreate([
                'bitrix_id' => $contactItem->ID,
                'app_id'    => $this->user->app_id,
            ], [
                'name'      => $contactItem->NAME,
                'surname'   => $contactItem->LAST_NAME,
                'last_name' => $contactItem->SECOND_NAME,
            ]);
            $contacts[$index]['id'] = $result->id;
        }

        return $contacts;
    }

    /**
     * @throws ValidatorException
     */
    private function synchronizePhones(array $contactsData): void
    {
        foreach ($contactsData as $contactItem) {
            foreach ($contactItem['phones'] as $phone) {
                $this->phoneRepository->updateOrCreate([
                    'phone'      => $this->formatPhoneNumber($phone['VALUE']),
                    'contact_id' => $contactItem['id'],
                ]);
            }
        }
    }
}
