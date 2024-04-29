<?php


namespace schedule\entities\Schedule\Service\queries;


use schedule\entities\Schedule\Service\Service;
use yii\db\ActiveQuery;

class ServiceQuery extends ActiveQuery
{
    public function active($alias = null): ServiceQuery
    {
        return $this->andWhere(
            [
                ($alias ? $alias . '.' : '') . 'status' => Service::STATUS_ACTIVE,
            ]
        );
    }
}