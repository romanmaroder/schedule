<?php


namespace core\helpers;


use core\entities\Schedule\Additional\Additional;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class AdditionalHelper
{
    public static function statusList(): array
    {
        return [
            Additional::STATUS_DRAFT => 'Draft',
            Additional::STATUS_ACTIVE => 'Active',
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
                   0, Additional::STATUS_DRAFT => $class ='badge badge-secondary',
                   Additional::STATUS_ACTIVE => $class = 'badge badge-success',
               };
       */
        switch ($status) {
            case Additional::STATUS_DRAFT:
                $class = 'badge badge-secondary';
                break;
            case Additional::STATUS_ACTIVE:
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