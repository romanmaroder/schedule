<?php


namespace schedule\helpers;


use schedule\entities\Schedule\Characteristic;
use yii\helpers\ArrayHelper;

class CharacteristicHelper
{

    /**
     * @return string[]
     */
    public static function typeList():array
    {
        return[
            Characteristic::TYPE_STRING => 'String',
            Characteristic::TYPE_INTEGER => 'Integer',
            Characteristic::TYPE_FLOAT => 'Float number',
        ];
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