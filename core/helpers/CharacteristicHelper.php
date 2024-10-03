<?php


namespace core\helpers;


use core\entities\CommonUses\Characteristic;
use yii\helpers\ArrayHelper;

class CharacteristicHelper
{

    /**
     * @return string[]
     */
    public static function typeList():array
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