<?php


namespace schedule\helpers;


use schedule\entities\Schedule\Service\Service;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ServiceHelper
{
    public static function statusList(): array
    {
        return [
            Service::STATUS_DRAFT => 'Draft',
            Service::STATUS_ACTIVE => 'Active',
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
}