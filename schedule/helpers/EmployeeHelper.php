<?php


namespace schedule\helpers;


use schedule\access\Rbac;
use schedule\entities\User\Employee\Employee;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\rbac\Item;

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

}