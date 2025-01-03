<?php


namespace core\helpers;


use core\access\Rbac;
use core\entities\User\Employee\Employee;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class EmployeeHelper
{
    #[ArrayShape([Employee::STATUS_INACTIVE => "string", Employee::STATUS_ACTIVE => "string"])]
    public static function statusList(): array
    {
        return [
            Employee::STATUS_INACTIVE => \Yii::t('app','Inactive'),
            Employee::STATUS_ACTIVE => \Yii::t('app','Active'),
        ];
    }

    public static function statusName(string $status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        $class = match ($status) {
            Employee::STATUS_INACTIVE => 'badge bg-danger bg-gradient text-shadow box-shadow',
            Employee::STATUS_ACTIVE => 'badge bg-success bg-gradient text-shadow box-shadow',
            default => 'badge bg-info',
        };

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::statusList(), $status),
            [
                'class' => $class,
            ]
        );
    }

    #[ArrayShape([
        Rbac::ROLE_ADMIN => "string",
        Rbac::ROLE_EMPLOYEE => "string",
        Rbac::ROLE_MANAGER => "string"
    ])] public static function rolesList(): array
    {
        return [
            Rbac::ROLE_ADMIN => Yii::t('role','admin'),
            Rbac::ROLE_EMPLOYEE => Yii::t('role','employee'),
            Rbac::ROLE_MANAGER => Yii::t('role','manager'),
        ];
    }

    public static function rolesLabel($userId): string
    {
        $roles = ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($userId), 'name');
        $role = ArrayHelper::getValue(self::rolesList(), $roles);

        $class = match ($role) {
            Rbac::ROLE_ADMIN => 'badge bg-danger bg-gradient box-shadow',
            Rbac::ROLE_MANAGER => 'badge bg-warning bg-gradient box-shadow',
            Rbac::ROLE_EMPLOYEE => 'badge bg-info bg-gradient box-shadow',
            default => 'badge bg-secondary',
        };

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::rolesList(), $roles),
            [
                'class' => $class,
            ]
        );
    }

}