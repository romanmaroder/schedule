<?php


namespace schedule\entities\Schedule\Service\queries;


use schedule\entities\Schedule\Service\Expenses;

class ServiceQuery extends \yii\db\ActiveQuery
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