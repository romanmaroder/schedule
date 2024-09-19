<?php


namespace core\entities\User;


use core\entities\Schedule\Service\Service;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ServiceAssignment
 * @package core\entities\Schedule\Event
 *
 * @property int $price_id [int(11)]
 * @property int $service_id [int(11)]
 * @property int $rate [int(11)]
 * @property int $cost [int(11)]
 * @property Service $services
 * @property Price $price
 */
class ServiceAssignment extends ActiveRecord
{

    public static function create($serviceId, $rate, $price): self
    {
        $assignment = new static();
        $assignment->service_id = $serviceId;
        $assignment->rate = $rate;
        $assignment->cost = $price;
        return $assignment;
    }


    public function edit($serviceId, $rate, $price, $cost): self
    {
        $this->service_id = $serviceId;
        $this->rate = $rate;
        $this->price_id = $price;
        $this->cost = $cost;
    }

    /**
     * @param $id
     * @return bool
     */
    public function isForPrice($id): bool
    {
        return $this->price_id == $id;
    }

    public function isForService($id): bool
    {
        return $this->service_id == $id;
    }

    public function getPrice(): ActiveQuery
    {
        return $this->hasOne(Price::class, ['id' => 'price_id']);
    }

    public function getServices(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    public function getAssignments($priceId, $serviceId)
    {
        if ($this->isForPrice($priceId) && $this->isForService($serviceId)) {
            return $this;
        }
    }

    public static function tableName(): string
    {
        return '{{%schedule_multiprice_assignments}}';
    }


}