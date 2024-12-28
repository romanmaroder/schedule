<?php


namespace core\helpers;


use core\entities\Schedule\Event\Event;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ToolsHelper
{
    #[ArrayShape([Event::TOOLS_ARE_NOT_READY => "string", Event::TOOLS_READY => "string"])]
    public static function statusList(): array
    {
        return [
            Event::TOOLS_ARE_NOT_READY => \Yii::t('schedule/event', 'TOOLS ARE NOT READY'),
            Event::TOOLS_READY => \Yii::t('schedule/event', 'TOOLS READY'),
        ];
    }

    public static function statusName($tools): string
    {
        return ArrayHelper::getValue(self::statusList(), $tools);
    }

    public static function statusLabel($tools): string
    {
        $class = match ($tools) {
            Event::TOOLS_ARE_NOT_READY => 'badge badge-secondary',
            Event::TOOLS_READY => 'badge badge-warning',
            default => 'badge badge-secondary',
        };
        $out = '';
        $out .= Html::beginTag('span', ['class' => $class]);
        $out .= Html::tag(
            'i',
            Event::TOOLS_ICON,
            [

            ]
        );
        $out .= Html::endTag('span');
        return $out;
    }
}