<?php


namespace core\helpers;


use core\entities\User\Price;
use yii\helpers\ArrayHelper;

class PricesHelper
{

    public static function priceList(): array
    {
        return ArrayHelper::map(
            Price::find()->asArray()->all(),
            'id',
            'name'
        );
    }

    public static function renderPrice($data)
    {
        $out = '';
        foreach ($data as $i => $service) {
            $out .= '<optgroup label="' . $i . '">';
            foreach ($service as $id => $name) {
                $out .= '<option value="' . $id . '">' . $name . '</option>';
            }
            $out .= '</optgroup>';
        }
        return $out;
    }

}