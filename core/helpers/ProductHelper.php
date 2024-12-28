<?php


namespace core\helpers;


use core\entities\Shop\Product\Product;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ProductHelper
{
    #[ArrayShape([Product::STATUS_DRAFT => "string", Product::STATUS_ACTIVE => "string"])]
    public static function statusList(): array
    {
        return [
            Product::STATUS_DRAFT => \Yii::t('app','Draft'),
            Product::STATUS_ACTIVE => \Yii::t('app','Active'),
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        $class = match ($status) {
            Product::STATUS_DRAFT => 'badge badge-secondary',
            Product::STATUS_ACTIVE => 'badge badge-success',
            default => 'badge badge-secondary',
        };

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}