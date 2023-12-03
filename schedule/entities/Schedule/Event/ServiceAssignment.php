<?php


namespace schedule\entities\Schedule\Event;


use yii\db\ActiveRecord;

/**
 * Class ServiceAssignment
 * @package schedule\entities\Schedule\Event
 *
 * @property int $event_id [int(11)]
 * @property int $service_id [int(11)]
 */
class ServiceAssignment extends ActiveRecord
{
    public static function create($serviceId):self
    {
        $assignment = new static();
        $assignment->service_id = $serviceId;
        return $assignment;
    }

    /**
     * @param $id
     * @return bool
     */
    public function isForEvent($id):bool
    {
        return $this->service_id == $id;
    }

    public static function tableName():string
    {
        return '{{%schedule_service_assignments}}';
    }
}