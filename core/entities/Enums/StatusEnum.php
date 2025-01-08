<?php

namespace core\entities\Enums;

use core\helpers\tHelper;

enum StatusEnum: int
{

    case STATUS_ACTIVE = 10;

    case STATUS_INACTIVE = 9;


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
            self::STATUS_ACTIVE->value => 'badge bg-success bg-gradient text-shadow box-shadow',
            self::STATUS_INACTIVE->value=> 'badge bg-danger bg-gradient text-shadow box-shadow',
            default => 'badge bg-info',
        };
    }

    private static function translate($enum): string
    {
        return match ($enum) {
            self::STATUS_ACTIVE => tHelper::translate('app', 'Active'),
            self::STATUS_INACTIVE => tHelper::translate('app', 'Inactive'),
            default => throw new \RuntimeException('Unknown status'),
        };
    }



}
