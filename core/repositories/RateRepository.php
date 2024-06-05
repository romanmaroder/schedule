<?php


namespace core\repositories;


use core\entities\User\Rate;

class RateRepository
{
    /**
     * @param $id
     * @return Rate
     */
    public function get($id): Rate
    {
        return $this->getBy(['id' => $id]);
    }


    /**
     * @param Rate $rate
     */
    public function save(Rate $rate): void
    {
        if (!$rate->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Rate $rate
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Rate $rate):void
    {
        if (!$rate->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    /**
     * @param array $condition
     * @return Rate
     */
    private function getBy(array $condition): Rate
    {
        if (!$rate = Rate::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('User not found.');
        }
        return $rate;
    }
}