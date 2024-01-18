<?php


namespace schedule\helpers;


use schedule\entities\User\Rate;
use yii\helpers\ArrayHelper;

class RateHelper
{
    public static function rateList(): array
    {
        return ArrayHelper::map(
            Rate::find()->asArray()->all(),
            'id',
            'name'
        );
    }
}