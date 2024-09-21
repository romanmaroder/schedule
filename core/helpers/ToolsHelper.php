<?php


namespace core\helpers;


use core\entities\Schedule\Event\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ToolsHelper
{
    public static function statusList(): array
    {
        return [
            Event::TOOLS_ARE_NOT_READY => 'TOOLS ARE NOT READY',
            Event::TOOLS_READY => 'TOOLS READY',
        ];
    }

    public static function statusName($tools): string
    {
        return ArrayHelper::getValue(self::statusList(), $tools);
    }

    public static function statusLabel($tools): string
    {
        /* $class = match ($tools) {
            Event::TOOLS_ARE_NOT_READY => 'badge badge-warning',
            Event::TOOLS_READY => 'badge badge-success',
            default => 'badge badge-secondary',
        };
       */
        switch ($tools) {
            case Event::TOOLS_ARE_NOT_READY:
                $class = 'badge badge-secondary';
                //$content = Event::TOOLS_ICON;
                break;
            case Event::TOOLS_READY:
                $class = 'badge badge-warning';
                //$content = Event::TOOLS_ICON;
                break;
            default:
                $class = 'badge badge-secondary';
                //$content = Event::TOOLS_ICON;
        }
        $out = '';
        $out .= Html::beginTag('span',['class'=>$class]);
            $out .= Html::tag('i',  Event::TOOLS_ICON, [

            ]);
        $out .= Html::endTag('span');
return  $out;
        /*return Html::tag('span', ArrayHelper::getValue(self::statusList(), $tools), [
            'class' => $class,
        ]);*/
    }
}