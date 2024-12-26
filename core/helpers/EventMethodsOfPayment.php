<?php


namespace core\helpers;


use core\entities\Schedule\Event\Event;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class EventMethodsOfPayment
{
    #[ArrayShape([Event::STATUS_CASH => "string", Event::STATUS_CARD => "string"])]
    public static function statusList(): array
    {
        return [
            Event::STATUS_CASH => \Yii::t('schedule/event','Cash'),
            Event::STATUS_CARD=>\Yii::t('schedule/event','Card')
        ];
    }

    public static function statusName(string $status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        $class = match ($status) {
            Event::STATUS_CARD => 'badge bg-info bg-gradient text-shadow box-shadow',
            Event::STATUS_CASH => 'badge bg-success bg-gradient text-shadow box-shadow',
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