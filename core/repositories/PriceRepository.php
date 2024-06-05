<?php


namespace core\repositories;


use core\entities\User\Price;

class PriceRepository
{
    /**
     * @param $id
     * @return Price
     */
    public function get($id): Price
    {
        return $this->getBy(['id' => $id]);
    }

    /**
     * @param Price $price
     */
    public function save(Price $price): void
    {
        if (!$price->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Price $price
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Price $price):void
    {
        if (!$price->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    /**
     * @param array $condition
     * @return Price
     */
    private function getBy(array $condition): Price
    {
        if (!$price = Price::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('Price not found.');
        }
        return $price;
    }
}