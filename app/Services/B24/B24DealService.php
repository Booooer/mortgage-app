<?php

namespace App\Services\B24;

use App\Helpers\UidHelper;
use App\Http\Requests\StoreTaskRequest;
use App\Repositories\B24ContactRepository;
use App\Traits\B24AppTrait;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealItemResult;
use DomDev\B24LaravelApp\Services\B24ApiService;
use Exception;

final class B24DealService
{
    use B24AppTrait;

    /**
     * @throws TransportException
     * @throws BaseException
     */
    private function getContactIds(int $dealId): array
    {
        $contacts = $this->b24App->getCRMScope()->dealContact()->itemsGet($dealId)->getDealContacts();

        return array_map(function ($contact) {
            return $contact->CONTACT_ID;
        }, $contacts);
    }

    /**
     * @throws TransportException
     * @throws InvalidArgumentException
     * @throws UnknownScopeCodeException
     * @throws BaseException
     */
    public function getDealContactIds(int $dealId): array
    {
        $this->setB24App();

        return $this->getContactIds($dealId);
    }
}
