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
 * @property int $payment [smallint(6)]
 * @property int $start
 * @property int $end
 * @property User $master
 * @property User $client
 * @property ServiceAssignment[] $serviceAssignments
 * @property Service $services
 * @property Employee $employee
 *
 * @property int $rate [int(11)]
 * @property int $price [int(11)]
 * @property string $fullname [varchar(255)]
 * @property string $default_color [varchar(255)]
 */
class Event extends ActiveRecord
{
    public const STATUS_NOT_PAYED = 0;
    public const STATUS_PAYED = 1;
    public const STATUS_CASH = 2;
    public const STATUS_CARD = 3;
    public const DEFAULT_COLOR = '#747d8c';
    public const EX_EMPLOYEE = ' <small><i class="fas fa-user-slash"></i></small>';

    public static function create(
        $masterId,
        $clientId,
        $notice,
        $start,
        $end,
        $discount,
        $discount_from,
        $status,
        $payment,
        $amount,
        $rate,
        $price,
        $fullname,
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
        $event->payment = self::STATUS_CASH;
        $event->amount = $amount;
        $event->rate = $rate;
        $event->price = $price;
        $event->fullname = $fullname;
        $event->default_color = self::DEFAULT_COLOR;
        return $event;
    }

    public function edit(
        $masterId,
        $clientId,
        $notice,
        $start,
        $end,
        $discount,
        $discount_from,
        $status,
        $payment,
        $amount,
        $rate,
        $price,
        $fullname,
    ): void {
        $this->master_id = $masterId;
        $this->client_id = $clientId;
        $this->notice = $notice;
        $this->start = $start;
        $this->end = $end;
        $this->discount = $discount;
        $this->discount_from = $discount_from;
        $this->status = $status;
        if ($this->isPayed()) {
            $this->payment = $payment;
            $this->amount = $amount;
        } else {
            $this->payment = null;
        }
        $this->rate = $rate;
        $this->price = $price;
        $this->fullname = $fullname;
    }

    public static function copy(
        $id,
        $masterId,
        $clientId,
        $notice,
        $start,
        $end,
        $discount,
        $discount_from,
        $status,
        $payment,
        $amount,
        $rate,
        $price,
        $fullname,
    ): self {
        $event = new static();
        $event->id = $id;
        $event->master_id = $masterId;
        $event->client_id = $clientId;
        $event->notice = $notice;
        $event->start = $start;
        $event->end = $end;
        $event->discount = $discount;
        $event->discount_from = $discount_from;
        $event->status = self::STATUS_NOT_PAYED;
        $event->payment = self::STATUS_CASH;
        $event->amount = $amount;
        $event->rate = $rate;
        $event->price = $price;
        $event->fullname = $fullname;
        return $event;
    }

    public function copied(): Event
    {
        return clone $this;
    }

    public function isPayed(): bool
    {
        return $this->status == self::STATUS_PAYED;
    }

    public function isNotPayed(): bool
    {
        return $this->status == self::STATUS_NOT_PAYED;
    }

    public function toPay(): int
    {
        return $this->status = self::STATUS_PAYED;
    }

    public function cancelPay(): int
    {
        return $this->status = self::STATUS_NOT_PAYED;
    }

    public function isCardPayment(): bool
    {
        return $this->payment == self::STATUS_CARD;
    }

    public function isCashPayment(): bool
    {
        return $this->payment == self::STATUS_CASH;
    }

    public function cardPayment(): int
    {
        return $this->payment = self::STATUS_CARD;
    }

    public function cashPayment(): int
    {
        return $this->payment = self::STATUS_CASH;
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

    public function getAmount($amount)
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

    public function getDiscountedPrice($model, $cart): float|int
    {
        return array_sum(
            array_map(
                function ($item) use ($model) {
                    if ($model->id == $item->getId()) {
                        return $item->getDiscountedPrice();
                    }
                    return false;
                },
                $cart->getItems()
            )
        );

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

    public function getFullName(): string
    {
        if ($this->employee){
            return $this->employee->getFullName();
        }
        return $this->fullname . self::EX_EMPLOYEE;
    }

    public function getDefaultColor(): string
    {
        if ($this->employee) {
            return $this->employee->color;
        }
            return self::DEFAULT_COLOR;
    }


    public function getRate(): int|float
    {
        if ($this->employee){
            return $this->employee->rate->rate;
        }
        return $this->rate;
    }


    public function getPrice(): int|float
    {
        if ($this->employee){
            return $this->employee->price->rate;
        }
        return $this->price;
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
                    'serviceAssignments',
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

    /*public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->getAttribute('amount') != $this->getOldAttribute('amount')) {
            $this->status = self::STATUS_NOT_PAYED;
        }
        return true;
    }*/

}