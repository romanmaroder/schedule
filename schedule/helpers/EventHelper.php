<?php


namespace schedule\helpers;


use schedule\entities\Schedule\Event\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class EventHelper
{
    public static function statusList(): array
    {
        return [
            Event::STATUS_NOT_PAYED => 'NO PAYED',
            Event::STATUS_PAYED => 'PAYED',
        ];
    }

    public static function statusName(string $status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Event::STATUS_NOT_PAYED:
                $class = 'badge bg-danger bg-gradient text-shadow box-shadow';
                break;
            case Event::STATUS_PAYED:
                $class = 'badge bg-success bg-gradient text-shadow box-shadow';
                break;
            default:
                $class = 'badge bg-danger bg-gradient text-shadow box-shadow';
        }

        /*$class = match ($status) {
            Event::STATUS_NOT_PAYED => 'badge bg-danger bg-gradient text-shadow box-shadow',
            Event::STATUS_PAYED => 'badge bg-success bg-gradient text-shadow box-shadow',
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