<?php


namespace core\helpers;


use core\entities\Shop\Order\Status;
use core\entities\Shop\Product\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class OrderHelper
{
    public static function statusList(): array
    {
        return [
            Status::NEW => 'New',
            Status::PAID => 'Paid',
            Status::SENT => 'Sent',
            Status::COMPLETED => 'Completed',
            Status::CANCELLED => 'Cancelled',
            Status::CANCELLED_BY_CUSTOMER => 'Cancelled by customer',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Product::STATUS_DRAFT:
                $class = 'badge bg-secondary bg-gradient text-shadow box-shadow';
                break;
            case Product::STATUS_ACTIVE:
                $class = 'badge bg-success bg-gradient text-shadow box-shadow';
                break;
            default:
                $class = 'badge bg-secondary bg-gradient text-shadow box-shadow';
        }

       /* $class = match ($status) {
            Product::STATUS_DRAFT => 'badge bg-secondary bg-gradient text-shadow box-shadow',
            Product::STATUS_ACTIVE => 'badge bg-success bg-gradient text-shadow box-shadow',
            default => 'badge bg-secondary bg-gradient text-shadow box-shadow',
        };*/

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}