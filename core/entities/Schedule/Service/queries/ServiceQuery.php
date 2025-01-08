<?php


namespace core\entities\Schedule\Service\queries;


use core\entities\Enums\StatusEnum;
use yii\db\ActiveQuery;

class ServiceQuery extends ActiveQuery
{
    public function active($alias = null): ServiceQuery
    {
        return $this->andWhere(
            [
                ($alias ? $alias . '.' : '') . 'status' => StatusEnum::STATUS_ACTIVE,
            ]
        );
    }
}