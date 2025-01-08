<?php

namespace core\entities\Enums;

use core\helpers\tHelper;
use JetBrains\PhpStorm\ArrayShape;

enum DiscountEnum: int
{
    /**
     * The client pays the full cost of the service according to the master’s price list.
     * Salary and income are calculated from the rates and price lists specified by the master.
     * If the rate and price list == 100%, the master’s salary is not calculated.
     */
    case NO_DISCOUNT = 0;

    /**
     * The master indicates the cost of the discount.
     * The discount is deducted from the master’s salary.
     * The client pays the cost of the service at a discount.
     */
    case MASTER_DISCOUNT = 1;

    /**
     * The discount is divided in half between the master and the salon.
     * It is deducted from the master’s salary and the salon’s income.
     * The client pays the cost of the service at a discount.
     */
    case STUDIO_DISCOUNT = 2;

    /**
     * The discount is deducted from the income.
     * The client pays the cost of the service at a discount.
     */
    case STUDIO_DISCOUNT_WITH_MASTER_WORK = 3;

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
            self::MASTER_DISCOUNT->value => 'badge bg-info bg-gradient text-shadow box-shadow',
            self::STUDIO_DISCOUNT->value => 'badge bg-warning bg-gradient box-shadow',
            self::STUDIO_DISCOUNT_WITH_MASTER_WORK->value => 'badge bg-primary bg-gradient text-shadow box-shadow',
            default => 'badge bg-danger bg-gradient text-shadow box-shadow',
        };
    }

    private static function translate($enum): string
    {
        return match ($enum) {
            self::NO_DISCOUNT => \Yii::t('schedule/event/discount','NO DISCOUNT'),
            self::MASTER_DISCOUNT => \Yii::t('schedule/event/discount','MASTER\'S DISCOUNT'),
            self::STUDIO_DISCOUNT => \Yii::t('schedule/event/discount','STUDIO DISCOUNT'),
            self::STUDIO_DISCOUNT_WITH_MASTER_WORK => \Yii::t('schedule/event/discount','STUDIO DISCOUNT WITH MASTER WORK'),
            default => throw new \RuntimeException('Unknown status'),
        };
    }



}
