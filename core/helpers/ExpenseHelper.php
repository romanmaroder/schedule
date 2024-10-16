<?php


namespace core\helpers;


use core\entities\Expenses\Expenses\Expenses;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ExpenseHelper
{
    public static function statusList(): array
    {
        return [
            Expenses::STATUS_DRAFT => \Yii::t('app','Draft'),
            Expenses::STATUS_ACTIVE => \Yii::t('app','Active'),
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
            case Expenses::STATUS_DRAFT:
                $class = 'badge badge-secondary';
                break;
            case Expenses::STATUS_ACTIVE:
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