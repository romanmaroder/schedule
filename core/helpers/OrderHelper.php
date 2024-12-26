<?php


namespace core\helpers;


use core\entities\Shop\Order\Status;
use core\entities\Shop\Product\Product;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class OrderHelper
{
    #[ArrayShape([
        Status::NEW => "string",
        Status::PAID => "string",
        Status::SENT => "string",
        Status::COMPLETED => "string",
        Status::CANCELLED => "string",
        Status::CANCELLED_BY_CUSTOMER => "string"
    ])] public static function statusList(): array
    {
        return [
            Status::NEW => \Yii::t('product/order','New'),
            Status::PAID => \Yii::t('product/order','Paid'),
            Status::SENT => \Yii::t('product/order','Sent'),
            Status::COMPLETED => \Yii::t('product/order','Completed'),
            Status::CANCELLED => \Yii::t('product/order','Cancelled'),
            Status::CANCELLED_BY_CUSTOMER => \Yii::t('product/order','Cancelled by customer'),
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        $class = match ($status) {
            Product::STATUS_DRAFT => 'badge bg-secondary bg-gradient text-shadow box-shadow',
            Product::STATUS_ACTIVE => 'badge bg-success bg-gradient text-shadow box-shadow',
            default => 'badge bg-secondary bg-gradient text-shadow box-shadow',
        };
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}
