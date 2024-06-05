<?php


namespace core\helpers;


use core\entities\Schedule\Product\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ProductHelper
{
    public static function statusList(): array
    {
        return [
            Product::STATUS_DRAFT => 'Draft',
            Product::STATUS_ACTIVE => 'Active',
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
                   0, Product::STATUS_DRAFT => $class ='badge badge-secondary',
                   Product::STATUS_ACTIVE => $class = 'badge badge-success',
               };
       */
        switch ($status) {
            case Product::STATUS_DRAFT:
                $class = 'badge badge-secondary';
                break;
            case Product::STATUS_ACTIVE:
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