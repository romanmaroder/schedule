<?php


namespace core\helpers;


use Yii;

class DateHelper
{
    public static function formatter($data): ?string
    {
       return Yii::$app->formatter->asDatetime($data, 'medium');
    }
}