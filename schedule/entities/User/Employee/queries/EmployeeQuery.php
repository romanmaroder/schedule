<?php


namespace schedule\entities\User\Employee\queries;


use schedule\entities\User\Employee\Employee;

class EmployeeQuery extends \yii\db\ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere(
            [
                ($alias ? $alias . '.' : '') . 'status' => Employee::STATUS_ACTIVE,
            ]
        );
    }
}