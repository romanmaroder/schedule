<?php


namespace core\helpers;


use core\entities\Schedule\Additional\Additional;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class AdditionalHelper
{
    #[ArrayShape([Additional::STATUS_DRAFT => "string", Additional::STATUS_ACTIVE => "string"])]
    public static function statusList(): array
    {
        return [
            Additional::STATUS_DRAFT => \Yii::t('app','Draft'),
            Additional::STATUS_ACTIVE => \Yii::t('app','Active'),
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        $class = match ($status) {
            Additional::STATUS_DRAFT => 'badge badge-secondary',
            Additional::STATUS_ACTIVE => 'badge badge-success',
            default => 'badge badge-secondary',
        };

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}