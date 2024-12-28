<?php


namespace core\helpers;


use core\cart\schedule\discount\Discount;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class DiscountHelper
{
    #[ArrayShape([
        Discount::NO_DISCOUNT => "string",
        Discount::MASTER_DISCOUNT => "string",
        Discount::STUDIO_DISCOUNT => "string",
        Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK => "string"
    ])] public static function discountList(): array
    {
        return [
            Discount::NO_DISCOUNT => \Yii::t('schedule/event/discount','NO DISCOUNT'),
            Discount::MASTER_DISCOUNT => \Yii::t('schedule/event/discount','MASTER\'S DISCOUNT'),
            Discount::STUDIO_DISCOUNT => \Yii::t('schedule/event/discount','STUDIO DISCOUNT'),
            Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK => \Yii::t('schedule/event/discount','STUDIO DISCOUNT WITH MASTER WORK'),
        ];
    }

    public static function discountName(string $discount): string
    {
        return ArrayHelper::getValue(self::discountList(), $discount);
    }

    public static function discountLabel($discount): string
    {
        $class = match ($discount) {
            Discount::NO_DISCOUNT => 'badge bg-danger bg-gradient text-shadow box-shadow',
            Discount::MASTER_DISCOUNT => 'badge bg-info bg-gradient text-shadow box-shadow',
            Discount::STUDIO_DISCOUNT => 'badge bg-warning bg-gradient text-shadow box-shadow',
            Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK => 'badge bg-primary bg-gradient text-shadow box-shadow',
            default => 'badge bg-danger bg-gradient text-shadow box-shadow',
        };

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::discountList(), $discount),
            [
                'class' => $class,
            ]
        );
    }
}