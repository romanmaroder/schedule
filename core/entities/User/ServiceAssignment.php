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
 * @property MultiPrice $multiPrice
 */
class ServiceAssignment extends ActiveRecord
{

    public static function create($serviceId,$rate,$price): self
    {
        $assignment = new static();
        $assignment->service_id = $serviceId;
        $assignment->rate = $rate;
        $assignment->cost = $price;
        return $assignment;
    }



    /**
     * @param $id
     * @return bool
     */
    public function isForEvent($id): bool
    {
        return $this->service_id == $id;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->service_id == $id;
    }

    public function getMultiPrice(): ActiveQuery
    {
        return $this->hasOne(MultiPrice::class, ['id' => 'price_id']);
    }

    public function getServices(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    public static function tableName(): string
    {
        return '{{%schedule_multiprice_assignments}}';
    }



}