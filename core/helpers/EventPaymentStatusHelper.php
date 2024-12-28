<?php


namespace core\helpers;


use core\entities\Schedule\Event\Event;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class EventPaymentStatusHelper
{
    #[ArrayShape([Event::STATUS_NOT_PAYED => "string", Event::STATUS_PAYED => "string"])]
    public static function statusList(): array
    {
        return [
            Event::STATUS_NOT_PAYED => \Yii::t('schedule/event','No pay'),
            Event::STATUS_PAYED => \Yii::t('schedule/event','Pay'),
        ];
    }

    public static function statusName(string $status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        $class = match ($status) {
            Event::STATUS_NOT_PAYED => 'badge bg-danger bg-gradient text-shadow box-shadow',
            Event::STATUS_PAYED => 'badge bg-success bg-gradient text-shadow box-shadow',
            default => 'badge bg-danger bg-gradient text-shadow box-shadow',
        };

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::statusList(), $status),
            [
                'class' => $class,
            ]
        );
    }
}