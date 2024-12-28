<?php


namespace core\helpers;


use core\entities\CommonUses\Characteristic;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;

class CharacteristicHelper
{

    /**
     * @return string[]
     */
    #[ArrayShape([
        Characteristic::TYPE_STRING => "string",
        Characteristic::TYPE_INTEGER => "string",
        Characteristic::TYPE_FLOAT => "string"
    ])] public static function typeList():array
    {
        return[
            Characteristic::TYPE_STRING => \Yii::t('product/product','String'),
            Characteristic::TYPE_INTEGER => \Yii::t('product/product','Integer'),
            Characteristic::TYPE_FLOAT => \Yii::t('product/product','Float number'),
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