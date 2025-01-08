<?php


namespace core\helpers;


use core\entities\Enums\DiscountEnum;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class DiscountHelper
{
     public static function discountList(): array
    {
        return DiscountEnum::getList();
    }

    public static function discountName(string $discount): string
    {
        return ArrayHelper::getValue(self::discountList(), $discount);
    }

    public static function discountLabel($discount): string
    {
        $class = DiscountEnum::getBadge($discount);

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::discountList(), $discount),
            [
                'class' => $class,
            ]
        );
    }
}