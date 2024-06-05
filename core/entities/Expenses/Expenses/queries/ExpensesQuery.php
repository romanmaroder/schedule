<?php


namespace core\entities\Expenses\Expenses\queries;


use core\entities\Expenses\Expenses\Expenses;

class ExpensesQuery extends \yii\db\ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere(
            [
                ($alias ? $alias . '.' : '') . 'status' => Expenses::STATUS_ACTIVE,
            ]
        );
    }
}