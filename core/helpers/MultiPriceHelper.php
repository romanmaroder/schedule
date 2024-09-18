<?php


namespace core\helpers;


use core\entities\User\MultiPrice;
use yii\helpers\ArrayHelper;

class MultiPriceHelper
{

    public static function priceList(): array
    {
        return ArrayHelper::map(
            MultiPrice::find()->asArray()->all(),
            'id',
            'name'
        );
    }

    public static function renderPrice($data)
    {

            $out = '';
            foreach ($data as $i=>$service) {

                    $out .= '<option value="' . $service['id'] . '">' . $service['name'] . '</option>';

            }

            return $out;
    }

}