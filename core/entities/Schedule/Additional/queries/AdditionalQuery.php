<?php


namespace core\entities\Schedule\Additional\queries;


use core\entities\Enums\StatusEnum;
use yii\db\ActiveQuery;

class AdditionalQuery extends ActiveQuery
{
    public function active($alias = null): AdditionalQuery
    {
        return $this->andWhere(
            [
                ($alias ? $alias . '.' : '') . 'status' => StatusEnum::STATUS_ACTIVE,
            ]
        );
    }
}