<?php


namespace schedule\entities\Schedule\Event;


use schedule\entities\Schedule\Service\Service;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ServiceAssignment
 * @package schedule\entities\Schedule\Event
 *
 * @property int $event_id [int(11)]
 * @property int $service_id [int(11)]
 * @property int $cost [int(11)]
 * @property Service $services
 * @property Event $events
 */
class ServiceAssignment extends ActiveRecord
{

    public static function create($serviceId,$price): self
    {
        $assignment = new static();
        $assignment->service_id = $serviceId;
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