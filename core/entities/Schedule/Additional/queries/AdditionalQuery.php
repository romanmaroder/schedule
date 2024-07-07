<?php


namespace core\entities\Schedule\Additional\queries;


use core\entities\Schedule\Additional\Additional;
use yii\db\ActiveQuery;

class AdditionalQuery extends ActiveQuery
{
    public function active($alias = null): AdditionalQuery
    {
        return $this->andWhere(
            [
                ($alias ? $alias . '.' : '') . 'status' => Additional::STATUS_ACTIVE,
            ]
        );
    }
}