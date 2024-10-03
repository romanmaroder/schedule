<?php


namespace core\helpers;


use yii\BaseYii;

class tHelper extends BaseYii
{
    public static function translate($category, $message, $params = [], $language = null): string
    {
       return self::t($category, $message, $params = [], $language = null);
    }

}