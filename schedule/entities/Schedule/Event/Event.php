<?php


namespace schedule\entities\Schedule\Event;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use schedule\entities\Schedule\Service\Service;
use schedule\entities\User\Employee\Employee;
use schedule\entities\User\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $master_id
 * @property int $client_id
 * @property string $notice
 * @property int $discount [int(11)]
 * @property int $discount_from [smallint(6)]
 * @property int $amount [int(11)]
 * @property int $status [smallint(6)]
 * @property int $start
 * @property int $end
 * @property User $master
 * @property User $client
 * @property ServiceAssignment[] $serviceAssignments
 * @property Service[] $services
 * @property Employee $employee
 */
class Event extends ActiveRecord
{
    public const STATUS_NOT_PAYED = 0;
    public const STATUS_PAYED = 1;

    public static function create(
        $masterId,
        $clientId,
        $notice,
        $start,
        $end,
        $discount,
        $discount_from,
        $status,
    ): self {
        $event = new static();
        $event->master_id = $masterId;
        $event->client_id = $clientId;
        $event->notice = $notice;
        $event->start = $start;
        $event->end = $end;
        $event->discount = $discount;
        $event->discount_from = $discount_from;
        $event->status = self::STATUS_NOT_PAYED;
        return $event;
    }

    public function edit($masterId, $clientId, $notice, $start, $end, $discount, $discount_from, $status): void
    {
        $this->master_id = $masterId;
        $this->client_id = $clientId;
        $this->notice = $notice;
        $this->start = $start;
        $this->end = $end;
        $this->discount = $discount;
        $this->discount_from = $discount_from;
        $this->status = $status;
    }

    public function isPayed():bool
    {
        return $this->status == self::STATUS_PAYED;
    }

    public function isNotPayed():bool
    {
        return $this->status == self::STATUS_NOT_PAYED;
    }
    public function assignService($id, $price): void
    {
        $assignments = $this->serviceAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForEvent($id)) {
                return;
            }
        }
        $assignments[] = ServiceAssignment::create($id, $price);
        $this->serviceAssignments = $assignments;
    }

    public function amount($amount): int
    {
        return $this->amount = $amount;
    }

    public function getDiscount(): int|null
    {
        if ($this->discount == null){
            return 0;
        }
        return $this->discount;
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

    public function getEmployee(): ActiveQuery
    {
        return $this->hasOne(Employee::class,['user_id'=>'master_id']);
    }

    public function issetNotice($notice):bool
    {
        if (!$notice){
            return false;
        }
        return true;
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