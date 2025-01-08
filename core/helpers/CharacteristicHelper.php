<?php


namespace core\helpers;


use core\entities\CommonUses\Characteristic;
use core\entities\Enums\CharacteristicEnum;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;

class CharacteristicHelper
{

    /**
     * @return string[]
     */
     public static function typeList():array
    {
        return CharacteristicEnum::getList();
    }

    /**
     * @param $type
     * @return string
     * @throws \Exception
     */
    public static function typeName($type):string
    {
        return ArrayHelper::getValue(self::typeList(),$type);
    }
}