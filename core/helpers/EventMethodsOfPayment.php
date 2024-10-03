<?php


namespace core\helpers;


use core\entities\Schedule\Event\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class EventMethodsOfPayment
{
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
        switch ($status) {
            case Event::STATUS_CARD:
                $class = 'badge bg-info bg-gradient text-shadow box-shadow';
                break;
            case Event::STATUS_CASH:
                $class = 'badge bg-success bg-gradient text-shadow box-shadow';
                break;
            default:
                $class = 'badge bg-danger bg-gradient text-shadow box-shadow';
        }

        /*$class = match ($status) {
            Event::STATUS_CARD => 'badge bg-info bg-gradient text-shadow box-shadow',
            Event::STATUS_CASH => 'badge bg-warning bg-gradient text-shadow box-shadow',
            default => 'badge bg-danger bg-gradient text-shadow box-shadow',
        };*/

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::statusList(), $status),
            [
                'class' => $class,
            ]
        );
    }
}