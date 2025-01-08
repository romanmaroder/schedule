<?php


namespace core\entities\Expenses\Expenses\queries;


use core\entities\Enums\StatusEnum;

class ExpensesQuery extends \yii\db\ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere(
            [
                ($alias ? $alias . '.' : '') . 'status' => StatusEnum::STATUS_ACTIVE,
            ]
        );
    }
}