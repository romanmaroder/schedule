<?php


namespace core\helpers;


use core\entities\Enums\PaymentOptionsEnum;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class EventMethodsOfPayment
{
    public static function statusList(): array
    {
        return PaymentOptionsEnum::getList();
    }

    public static function statusLabel($status): string
    {
        $class = PaymentOptionsEnum::getBadge($status);

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::statusList(), $status),
            [
                'class' => $class,
            ]
        );
    }
}