<?php

namespace App\Helpers;

use App\Repositories\B24ContactRepository;
use App\Repositories\BankRepository;
use App\Repositories\EmploymentTypeRepository;
use App\Repositories\InitPaymentSourceRepository;
use App\Repositories\LiveComplexRepository;
use App\Repositories\MaritalStatusRepository;
use App\Repositories\MortgageTypeRepository;
use App\Repositories\PhoneRepository;

readonly class UidHelper
{
    public function __construct(
        private MortgageTypeRepository      $mortgageTypeRepository,
        private LiveComplexRepository       $liveComplexRepository,
        private InitPaymentSourceRepository $initPaymentSourceRepository,
        public BankRepository               $bankRepository,
        private B24ContactRepository        $b24ContactRepository,
        private PhoneRepository             $phoneRepository,
        private EmploymentTypeRepository    $employmentTypeRepository,
        private MaritalStatusRepository     $maritalStatusRepository
    ) {
    }

    public function findByUid(string $uid, string $repositoryClass)
    {
        $result = match ($repositoryClass) {
            MortgageTypeRepository::class => $this->mortgageTypeRepository->findByField('uid', $uid),
            LiveComplexRepository::class => $this->liveComplexRepository->findByField('uid', $uid),
            InitPaymentSourceRepository::class => $this->initPaymentSourceRepository->findByField('uid', $uid),
            BankRepository::class => $this->bankRepository->findByField('uid', $uid),
            B24ContactRepository::class => $this->b24ContactRepository->findByField('uid', $uid),
            PhoneRepository::class => $this->phoneRepository->findByField('uid', $uid),
            MaritalStatusRepository::class => $this->maritalStatusRepository->findByField('uid', $uid),
            EmploymentTypeRepository::class => $this->employmentTypeRepository->findByField('uid', $uid),
            default => throw new \InvalidArgumentException(),
        };

        return $result->first();
    }

    public function findTitleByUid(string $uid, string $repositoryClass)
    {
        return $this->findByUid($uid, $repositoryClass)->title;
    }

    public function findIdByUid(string $uid, string $repositoryClass)
    {
        return $this->findByUid($uid, $repositoryClass)->id;
    }
}
