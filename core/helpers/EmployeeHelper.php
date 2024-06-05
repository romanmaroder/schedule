<?php


namespace core\helpers;


use core\access\Rbac;
use core\entities\User\Employee\Employee;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class EmployeeHelper
{
    public static function statusList(): array
    {
        return [
            Employee::STATUS_INACTIVE => 'Inactive',
            Employee::STATUS_ACTIVE => 'Active',
        ];
    }

    public static function statusName(string $status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Employee::STATUS_INACTIVE:
                $class = 'badge bg-danger bg-gradient text-shadow box-shadow';
                break;
            case Employee::STATUS_ACTIVE:
                $class = 'badge bg-success bg-gradient text-shadow box-shadow';
                break;
            default:
                $class = 'badge bg-info';
        }

       /* $class = match ($status) {
            Employee::STATUS_INACTIVE => 'badge bg-danger bg-gradient text-shadow box-shadow',
            Employee::STATUS_ACTIVE => 'badge bg-success bg-gradient text-shadow box-shadow',
            default => 'label label-default',
        };
        };*/

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::statusList(), $status),
            [
                'class' => $class,
            ]
        );
    }

    public static function rolesList(): array
    {
        return [
            Rbac::ROLE_ADMIN => 'admin',
            Rbac::ROLE_EMPLOYEE => 'employee',
            Rbac::ROLE_MANAGER => 'manager',
        ];
    }

    public static function rolesLabel($userId): string
    {
        $roles = ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($userId), 'name');
        $role = ArrayHelper::getValue(self::rolesList(), $roles);

        switch ($role) {
            case Rbac::ROLE_ADMIN:
                $class = 'badge bg-danger bg-gradient box-shadow';
                break;
            case Rbac::ROLE_MANAGER:
                $class = 'badge bg-warning bg-gradient box-shadow';
                break;
            case Rbac::ROLE_EMPLOYEE:
                $class = 'badge bg-info bg-gradient box-shadow';
                break;
            default:
                $class = 'badge bg-secondary';
        }

        /* $class = match ($role) {
            Rbac::ROLE_ADMIN => 'badge bg-danger bg-gradient box-shadow',
            Rbac::ROLE_MANAGER => 'badge bg-warning bg-gradient box-shadow',
            Rbac::ROLE_EMPLOYEE => 'badge bg-info bg-gradient box-shadow',
            default => 'badge bg-secondary',
        };*/

        return Html::tag(
            'span',
            ArrayHelper::getValue(self::rolesList(), $roles),
            [
                'class' => $class,
            ]
        );
    }

}