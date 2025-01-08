<?php

namespace core\entities\Enums;

use core\helpers\tHelper;

enum CharacteristicEnum:string
{
    case TYPE_STRING = 'string';
    case TYPE_INTEGER = 'integer';
    case TYPE_FLOAT = 'float';

    public static function getList(): array
    {
        $res = [];
        foreach (self::cases() as $case) {
            $res[$case->value] = self::translate($case);
        }
        return $res;
    }


    private static function translate($enum): string
    {
        return match ($enum) {
            self::TYPE_STRING => \Yii::t('product/product','String'),
            self::TYPE_INTEGER => \Yii::t('product/product','Integer'),
            self::TYPE_FLOAT => \Yii::t('product/product','Float number'),
            default => throw new \RuntimeException('Unknown status'),
        };
    }
}
