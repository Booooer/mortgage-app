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

    public static function getLiveComplexFieldTitle(string $liveComplex): string
    {
        return self::LIVE_COMPLEX->value . ': ' . $liveComplex;
    }
}
