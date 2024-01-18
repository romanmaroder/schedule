<?php


namespace schedule\helpers;


use schedule\entities\User\Price;
use yii\helpers\ArrayHelper;

class PriceHelper
{

    public static function format($price): string
    {
        return number_format($price, 0, '.', ' ');
    }

    public static function priceList(): array
    {
        return ArrayHelper::map(
            Price::find()->asArray()->all(),
            'id',
            'name'
        );
    }
}