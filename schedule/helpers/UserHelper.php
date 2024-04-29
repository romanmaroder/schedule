<?php


namespace schedule\helpers;


use schedule\entities\User\Employee\Employee;
use schedule\entities\User\User;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserHelper
{
    public static function statusList(): array
    {
        return [
            User::STATUS_INACTIVE => 'Inactive',
            User::STATUS_ACTIVE => 'Active',
        ];
    }

    public static function statusName(string $status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case User::STATUS_INACTIVE:
                $class = 'badge bg-danger bg-gradient text-shadow box-shadow';
                break;
            case User::STATUS_ACTIVE:
                $class = 'badge bg-success bg-gradient text-shadow box-shadow';
                break;
            default:
                $class = 'badge bg-info';
        }

        /*$class = match ($status) {
            User::STATUS_INACTIVE => 'badge bg-danger bg-gradient text-shadow box-shadow',
            User::STATUS_ACTIVE => 'badge bg-success bg-gradient text-shadow box-shadow',
            default => 'badge bg-info',
        };*/

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

}