<?php

namespace core\entities\Enums;


use core\helpers\tHelper;

enum PaymentOptionsEnum: int
{

    case STATUS_CASH = 2;

    case STATUS_CARD = 3;

    public static function getItem($value): int
    {
        foreach (self::cases() as $case) {
            if ($case->value == $value) {
                return $case->value;
            }
        };
        throw new \RuntimeException('Unknown status');
    }

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
            self::STATUS_CASH->value => 'badge bg-success bg-gradient text-shadow box-shadow',
            self::STATUS_CARD->value=> 'badge bg-info bg-gradient text-shadow box-shadow',
            default => 'badge bg-danger bg-gradient text-shadow box-shadow',
        };
    }

    private static function translate(PaymentOptionsEnum $enum): string
    {
        return match ($enum) {
            self::STATUS_CASH => tHelper::translate('schedule/event','Cash'),
            self::STATUS_CARD => tHelper::translate('schedule/event','Card'),
            default => throw new \RuntimeException('Unknown status'),
        };
    }


}
