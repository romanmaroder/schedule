<?php


namespace core\entities\Schedule\Event;


use core\entities\Schedule\Service\Service;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ServiceAssignment
 * @package core\entities\Schedule\Event
 *
 * @property int $event_id [int(11)]
 * @property int $service_id [int(11)]
 * @property int $original_cost [int(11)]
 * @property int $price_rate [int(11)]
 * @property int $price_cost [int(11)]
 * @property Service $services
 * @property Event $events
 */
class ServiceAssignment extends ActiveRecord
{

    public static function create($serviceId,$serviceCost,$priceRate,$priceCost): self
    {
        $assignment = new static();
        $assignment->service_id = $serviceId;
        $assignment->original_cost = $serviceCost;
        $assignment->price_rate = $priceRate;
        $assignment->price_cost = $priceCost;
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

    public function getEvents(): ActiveQuery
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }

    public function getServices(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    public static function tableName(): string
    {
        return '{{%schedule_service_assignments}}';
    }



}