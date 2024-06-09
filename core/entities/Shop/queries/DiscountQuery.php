<?php


namespace core\entities\Shop\queries;


use yii\db\ActiveQuery;

class DiscountQuery extends ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['active' => true]);
    }
}