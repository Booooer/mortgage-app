<?php

namespace App\Enums;

enum TaskEnum: string
{
    case LIVE_COMPLEX = 'Живой комплекс';
    case SALARY_BANK = 'ЗП Банк';
    case EMPLOYMENT_TYPE = 'Трудоустройство';
    case MARITAL_STATUS = 'Семейное положение';
    case HAVE_CHILDREN = 'Дети';
    case MORTGAGE_TYPE = 'Тип ипотеки';
    case WISHED_SUM = 'Желаемая сумма кредита, руб';
    case HAVE_INIT_PAYMENT = 'Есть перв.взнос';

    private function prepareFieldTitle(): string
    {
        return "\n" . '<b>' . $this->value . ':</b> ';
    }

    public static function getLiveComplexFieldTitle(string $liveComplex): string
    {
        return self::LIVE_COMPLEX->prepareFieldTitle() . $liveComplex;
    }

    public static function getSalaryBankFieldTitle(string $salaryBank): string
    {
        return self::SALARY_BANK->prepareFieldTitle() . $salaryBank;
    }

    public static function getEmploymentTypeFieldTitle(string $employmentType): string
    {
        return self::EMPLOYMENT_TYPE->prepareFieldTitle() . $employmentType;
    }

    public static function getMaritalStatusFieldTitle(string $maritalStatus): string
    {
        return self::MARITAL_STATUS->prepareFieldTitle() . $maritalStatus;
    }

    public static function getHaveChildrenFieldTitle(bool $haveChildren): string
    {
        return self::HAVE_CHILDREN->prepareFieldTitle() . ($haveChildren ? 'Да' : 'Нет');
    }

    public static function getMortgageTypeFieldTitle(string $mortgageType): string
    {
        return self::MORTGAGE_TYPE->prepareFieldTitle() . $mortgageType;
    }

    public static function getWishedSumFieldTitle(int $wishedSum): string
    {
        return self::WISHED_SUM->prepareFieldTitle() . $wishedSum;
    }

    public static function getHaveInitPaymentFieldTitle(bool $haveInitPayment): string
    {
        return self::HAVE_INIT_PAYMENT->prepareFieldTitle() . ($haveInitPayment ? 'Да' : 'Нет');
    }
}
