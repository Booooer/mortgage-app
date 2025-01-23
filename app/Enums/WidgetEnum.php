<?php

namespace App\Enums;

enum WidgetEnum: string
{
    case TASK_CODE = 'TASK_VIEW_TOP_PANEL';
    case DEAL_CODE = 'CRM_DEAL_DETAIL_ACTIVITY';
    case HANDLER = 'https://4w7y83-188-186-78-216.ru.tuna.am/test';

    public static function getWidgetConfig(): array
    {
        return [
            'ru' => [
                'TITLE'       => 'На оформление',
                'DESCRIPTION' => 'Внешнее приложение для задач на ипотеку',
                'GROUP_NAME'  => 'Ипотека',
            ],
        ];
    }

    public static function getHandler(): string
    {
        return self::HANDLER->value;
    }
}
