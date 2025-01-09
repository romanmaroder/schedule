<?php


namespace core\helpers;


use core\entities\Enums\StatusPayEnum;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class EventPaymentStatusHelper
{
    public static function getItem($value)
    {
        return StatusPayEnum::getItem($value);
    }
    public static function statusList(): array
    {
        return StatusPayEnum::getList();
    }

    public static function statusLabel($status): string
    {
        $class = StatusPayEnum::getBadge($status);

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::statusList(), $status),
            [
                'class' => $class,
            ]
        );
    }
}