<?php

namespace App\Services\B24;

use App\Repositories\B24InstallRepository;
use DomDev\B24LaravelApp\Data\B24InstallData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

final readonly class B24InstallService
{
    public function __construct(
        private B24InstallRepository $repository,
    ) {
    }

    public function install(B24InstallData $installData)
    {
        DB::beginTransaction();

        try {
            $result = $this->repository->firstOrCreate([
                'auth_id'                 => $installData->authId,
                'refresh_id'              => $installData->refreshId,
                'member_id'               => $installData->memberId,
                'app_sid'                 => $installData->appSid,
                'refresh_expires_in'      => $installData->refreshExpiresIn,
                'expires_in'              => $installData->expiresIn,
                'client_id'               => config('b24.marketplace_app.client_id'),
                'client_secret'           => config('b24.marketplace_app.client_secret'),
                'domain'                  => $installData->domain,
            ]);
            DB::commit();

            return $result;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::channel('b24')->error($e->getMessage());

            return false;
        }
    }
}
