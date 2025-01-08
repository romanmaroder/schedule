<?php


namespace core\helpers;


use core\entities\Enums\UserRolesEnum;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class EmployeeHelper
{
    public static function rolesList(): array
    {
        return UserRolesEnum::getList();
    }

    public static function rolesLabel($userId): string
    {
        $roles = ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($userId), 'name');
        $role = ArrayHelper::getValue(self::rolesList(), $roles);

        $class = UserRolesEnum::getBadge($role);

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::rolesList(), $roles),
            [
                'class' => $class,
            ]
        );
    }

}