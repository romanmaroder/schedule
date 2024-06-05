<?php


namespace core\helpers;


use core\entities\User\Role;
use yii\helpers\ArrayHelper;

class RoleHelper
{
    public static function roleList(): array
    {
        return ArrayHelper::map(
            Role::find()->asArray()->all(),
            'id',
            'name'
        );
    }
}