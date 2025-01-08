<?php


namespace core\helpers;


use yii\helpers\ArrayHelper;

class ServiceHelper
{
    public static function priceList($services): string
    {
       return $services =  array_sum(ArrayHelper::getColumn($services,function($element){
            return $element['price_cost'];
        }));

    }

    public static function detailedPriceList($services): string
    {
        return implode(', ', ArrayHelper::getColumn($services, function ($element) {
            return $element['services']['name'] . ' - '. $element['price_cost'];
        }));
    }
}