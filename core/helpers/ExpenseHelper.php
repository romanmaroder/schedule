<?php


namespace core\helpers;


use core\entities\Expenses\Expenses\Expenses;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ExpenseHelper
{
    #[ArrayShape([Expenses::STATUS_DRAFT => "string", Expenses::STATUS_ACTIVE => "string"])]
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
        $class = match ($status) {
            Expenses::STATUS_DRAFT => 'badge badge-secondary',
            Expenses::STATUS_ACTIVE => 'badge badge-success',
            default => 'badge badge-secondary',
        };

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}