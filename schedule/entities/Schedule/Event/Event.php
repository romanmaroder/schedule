<?php


namespace schedule\entities\Schedule\Event;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use schedule\entities\Schedule\Service\Service;
use schedule\entities\User\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $master_id
 * @property int $client_id
 * @property string $notice
 * @property int $start
 * @property int $end
 * @property User $master
 * @property User $client
 * @property ServiceAssignment[] $serviceAssignments
 * @property Service[] $services
 */
class Event extends ActiveRecord
{

    public static function create($masterId, $clientId, $notice, $start, $end): self
    {
        $event = new static();
        $event->master_id = $masterId;
        $event->client_id = $clientId;
        $event->notice = $notice;
        $event->start = $start;
        $event->end = $end;
        return $event;
    }

    public function edit($masterId, $clientId, $notice, $start, $end): void
    {
        $this->master_id = $masterId;
        $this->client_id = $clientId;
        $this->notice = $notice;
        $this->start = $start;
        $this->end = $end;
    }

    public function assignService($id): void
    {
        $assignments = $this->serviceAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForEvent($id)) {
                return;
            }
        }
        $assignments[] = ServiceAssignment::create($id);
        $this->serviceAssignments = $assignments;
    }

    public function revokeService($id): void
    {
        $assignments = $this->serviceAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForEvent($id)) {
                unset($assignments[$i]);
                $this->serviceAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeServices(): void
    {
        $this->serviceAssignments = [];
    }

    /**
     * @return ActiveQuery
     */
    public function getServiceAssignments(): ActiveQuery
    {
        return $this->hasMany(ServiceAssignment::class, ['event_id' => 'id']);
    }

    public function getServices(): ActiveQuery
    {
        return $this->hasMany(Service::class, ['id' => 'service_id'])
            ->viaTable('schedule_service_assignments',['event_id'=>'id']);
    }

    public function getMaster(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'master_id']);
    }

    public function getClient(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
    }

    public static function tableName(): string
    {
        return '{{%schedule_events}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'serviceAssignments'
                ],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
}