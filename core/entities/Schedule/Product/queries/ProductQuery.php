<?php


namespace core\entities\Schedule\Product\queries;


use core\entities\Schedule\Product\Product;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere(
            [
                ($alias ? $alias . '.' : '') . 'status' => Product::STATUS_ACTIVE,
            ]
        );
    }
}