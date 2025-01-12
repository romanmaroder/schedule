<?php


namespace core\helpers;


use core\entities\Enums\IconEnum;
use core\entities\Enums\ToolsEnum;
use yii\helpers\Html;

class ToolsHelper
{
    public static function statusList(): array
    {
        return ToolsEnum::getList();
    }

    public static function statusLabel($tools): string
    {
        $class = ToolsEnum::getBadge($tools);
        $out = Html::beginTag('span', ['class' => $class]);
        $out .= Html::tag(
            'i',
            IconEnum::TOOLS_ICON->value,
            [

            ]
        );
        $out .= Html::endTag('span');
        return $out;
    }
}