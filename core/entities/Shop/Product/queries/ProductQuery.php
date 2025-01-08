<?php


namespace core\entities\Shop\Product\queries;


use core\entities\Enums\StatusEnum;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
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