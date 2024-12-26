<?php


namespace core\helpers;


use core\entities\Schedule\Service\Service;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ServiceHelper
{
    #[ArrayShape([Service::STATUS_DRAFT => "string", Service::STATUS_ACTIVE => "string"])]
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
        $class = match ($status) {
            Service::STATUS_DRAFT => 'badge badge-secondary',
            Service::STATUS_ACTIVE => 'badge badge-success',
            default => 'badge badge-secondary',
        };

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