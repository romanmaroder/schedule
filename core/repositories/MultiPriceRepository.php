<?php


namespace core\repositories;


use core\entities\User\MultiPrice;

class MultiPriceRepository
{
    /**
     * @param $id
     * @return MultiPrice
     */
    public function get($id): MultiPrice
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByValue($value):MultiPrice
    {
        return $this->getBy(['rate' => $value]);
    }

    /**
     * @param MultiPrice $price
     * @throws \yii\db\Exception
     */
    public function save(MultiPrice $price): void
    {
        if (!$price->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param MultiPrice $price
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(MultiPrice $price):void
    {
        if (!$price->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    /**
     * @param array $condition
     * @return MultiPrice
     */
    private function getBy(array $condition): MultiPrice
    {
        if (!$price = MultiPrice::find()->where($condition)->limit(1)->one()) {
            throw new NotFoundException('Price not found.');
        }
        return $price;
    }
}