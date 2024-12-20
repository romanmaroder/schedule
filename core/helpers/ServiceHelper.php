<?php


namespace core\helpers;


use core\entities\Schedule\Service\Service;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ServiceHelper
{
    public static function statusList(): array
    {
        return [
            Service::STATUS_DRAFT => \Yii::t('app','Draft'),
            Service::STATUS_ACTIVE => \Yii::t('app','Active'),
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        /* Match expression is only allowed since PHP 8.0
               match ($status) {
                   0, Service::STATUS_DRAFT => $class ='badge badge-secondary',
                   Service::STATUS_ACTIVE => $class = 'badge badge-success',
               };
       */
        switch ($status) {
            case Service::STATUS_DRAFT:
                $class = 'badge badge-secondary';
                break;
            case Service::STATUS_ACTIVE:
                $class = 'badge badge-success';
                break;
            default:
                $class = 'badge badge-secondary';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

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