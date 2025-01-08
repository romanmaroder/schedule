<?php

namespace core\entities\Enums;


use core\helpers\tHelper;

enum StatusPayEnum: int
{

    case STATUS_NOT_PAYED = 0;

    case STATUS_PAYED = 1;



    public static function getList(): array
    {
        $res = [];
        foreach (self::cases() as $case) {
            $res[$case->value] = self::translate($case);
        }
        return $res;
    }

    public static function getBadge($enum): string
    {
        return match ($enum) {
            self::STATUS_PAYED->value => 'badge bg-success bg-gradient text-shadow box-shadow',
            self::STATUS_NOT_PAYED->value=> 'badge bg-danger bg-gradient text-shadow box-shadow',
            default => 'badge bg-info',
        };
    }

    private static function translate(StatusPayEnum $enum): string
    {
        return match ($enum) {
            self::STATUS_NOT_PAYED => tHelper::translate('schedule/event', 'No pay'),
            self::STATUS_PAYED => tHelper::translate('schedule/event', 'Pay'),
            default => throw new \RuntimeException('Unknown status'),
        };
    }


}
