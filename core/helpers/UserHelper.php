<?php


namespace core\helpers;


use core\entities\Enums\UserStatusEnum;
use core\entities\User\User;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserHelper
{
    public static function statusList(): array
    {
        return UserStatusEnum::getList();
    }

    public static function statusName(string $status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        $class = UserStatusEnum::getBadge($status);

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::statusList(), $status),
            [
                'class' => $class,
            ]
        );
    }

    public static function clientList(): ActiveQuery
    {
        return User::find()
            ->leftJoin('schedule_employees', 'schedule_employees.user_id=users.id')
            ->where(['is', 'schedule_employees.user_id', null]);
    }

    public static function hasRoleAccess($userId, array $rolesName): bool
    {
        $authManager = \Yii::$app->authManager;

        $userRoles = [];
        $userAssigned = $authManager->getAssignments($userId);

        foreach ($userAssigned as $userAssign) {
            $userRoles[] = $userAssign->roleName;
        }

        $access = false;
        foreach ($rolesName as $name) {
            if (in_array($name, $userRoles)) {
                $access = true;
            }
        }
        if ($access) {
            return true;
        }
        return false;
    }

}