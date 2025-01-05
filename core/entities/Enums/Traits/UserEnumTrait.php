<?php

namespace core\entities\Enums\Traits;

use core\entities\Enums\Interface\UserEnumInterface;

trait UserEnumTrait
{

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
            self::STATUS_INACTIVE->value => 'badge bg-danger bg-gradient text-shadow box-shadow',
            default => 'badge bg-info',
        };
    }

    private static function translate(UserEnumInterface $enum): string
    {
        return match ($enum) {
            self::STATUS_ACTIVE => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE => \Yii::t('app', 'Inactive'),
            default => throw new \RuntimeException('Unknown status'),
        };
    }


    /*public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }*/

}