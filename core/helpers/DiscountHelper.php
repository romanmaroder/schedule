<?php


namespace core\helpers;


use core\cart\discount\Discount;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class DiscountHelper
{
    public static function discountList(): array
    {
        return [
            Discount::NO_DISCOUNT => 'NO DISCOUNT',
            Discount::MASTER_DISCOUNT => 'MASTER\'S DISCOUNT',
            Discount::STUDIO_DISCOUNT => 'STUDIO DISCOUNT',
            Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK => 'STUDIO DISCOUNT WITH MASTER WORK',
        ];
    }

    public static function discountName(string $discount): string
    {
        return ArrayHelper::getValue(self::discountList(), $discount);
    }

    public static function discountLabel($discount): string
    {
        switch ($discount) {
            case Discount::NO_DISCOUNT:
                $class = 'badge bg-danger bg-gradient text-shadow box-shadow';
                break;
            case Discount::MASTER_DISCOUNT:
                $class = 'badge bg-info bg-gradient text-shadow box-shadow';
                break;
            case Discount::STUDIO_DISCOUNT:
                $class = 'badge bg-warning bg-gradient text-shadow box-shadow';
                break;
            case Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK:
                $class = 'badge bg-primary bg-gradient text-shadow box-shadow';
                break;
            default:
                $class = 'badge bg-danger bg-gradient text-shadow box-shadow';
        }

        /*$class = match ($discount) {
            Discount::NO_DISCOUNT => 'badge bg-danger',
            Discount::MASTER_DISCOUNT => 'badge bg-info',
            Discount::STUDIO_DISCOUNT => 'badge bg-warning',
            Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK => 'badge bg-primary',
            default => 'badge bg-danger',
        };*/

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::discountList(), $discount),
            [
                'class' => $class,
            ]
        );
    }
}