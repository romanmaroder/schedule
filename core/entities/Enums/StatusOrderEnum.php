<?php

namespace core\entities\Enums;

use core\helpers\tHelper;

enum StatusOrderEnum: int
{
    case NEW = 1;
    case PAID = 2;
    case SENT = 3;
    case COMPLETED = 4;
    case CANCELLED = 5;
    case CANCELLED_BY_CUSTOMER = 6;

    public static function getList(): array
    {
        $res = [];
        foreach (self::cases() as $case) {
            $res[$case->value] = self::translate($case);
        }
        return $res;
    }

    private static function translate($enum): string
    {
        return match ($enum) {
            self::NEW => \Yii::t('product/order','New'),
            self::PAID => \Yii::t('product/order','Paid'),
            self::SENT => \Yii::t('product/order','Sent'),
            self::COMPLETED => \Yii::t('product/order','Completed'),
            self::CANCELLED => \Yii::t('product/order','Cancelled'),
            self::CANCELLED_BY_CUSTOMER => \Yii::t('product/order','Cancelled by customer'),
            default => throw new \RuntimeException('Unknown status'),
        };
    }
}
