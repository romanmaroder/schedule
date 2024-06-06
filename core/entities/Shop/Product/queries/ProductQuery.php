<?php


namespace core\entities\Shop\Product\queries;


use core\entities\Shop\Product\Product;
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