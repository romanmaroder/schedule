<?php


namespace core\entities\User\Employee\queries;



use core\entities\Enums\StatusEnum;

class EmployeeQuery extends \yii\db\ActiveQuery
{
    public function active($alias = null): EmployeeQuery
    {
        return $this->andWhere(
            [
                ($alias ? $alias . '.' : '') . 'status' => StatusEnum::STATUS_ACTIVE,
            ]
        );
    }
}