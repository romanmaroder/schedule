<?php


namespace core\helpers;


use core\entities\Enums\StatusEnum;
use core\entities\Enums\StatusOrderEnum;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class OrderHelper
{
    public static function statusList(): array
    {
        return StatusOrderEnum::getList();
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        $class = StatusEnum::getBadge($status);
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}
