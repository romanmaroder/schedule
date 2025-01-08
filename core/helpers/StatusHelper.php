<?php

namespace core\helpers;

use core\entities\Enums\StatusEnum;
use Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class StatusHelper
{

    public static function statusList(): array
    {
        return StatusEnum::getList();
    }

    /**
     * @throws Exception
     */
    public static function statusLabel($status): string
    {
        $class = StatusEnum::getBadge($status);

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}