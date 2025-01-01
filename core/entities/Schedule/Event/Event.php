<?php


namespace core\entities\Schedule\Event;


use core\entities\Schedule\Service\Service;
use core\entities\User\Employee\Employee;
use core\entities\User\User;
use core\helpers\tHelper;
use core\services\bots\classes\BotMessenger;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Telegram\Bot\Exceptions\TelegramSDKException;
use yii\behaviors\TimestampBehavior;
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
 * @property string $fullname [varchar(255)]
 * @property string $default_color [varchar(255)]
 * @property int $tools [smallint(6)]
 * @property int $created_at [int(11) unsigned]
 * @property int $updated_at [int(11) unsigned]
 */
class Event extends ActiveRecord
{
    public const STATUS_NOT_PAYED = 0;
    public const STATUS_PAYED = 1;
    public const STATUS_CASH = 2;
    public const STATUS_CARD = 3;
    public const DEFAULT_COLOR = '#747d8c';
    public const EX_EMPLOYEE = ' <small><i class="fas fa-user-slash"></i></small>';

    public const TOOLS_ARE_NOT_READY = 0;
    public const TOOLS_READY = 1;
    public const TOOLS_ICON = '<i class="fas fa-wrench"></i>';

    public const CACHE_KEY = 'event';


    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'notifyUser']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'notifyUser']);
    }

    public function notifyUser(): void
    {

            $notify = new BotMessenger();
            $notify->Telegram()->send($this);
            //$notify->toViber()->send($data);
    }


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
        $event->fullname = $fullname;
        $event->default_color = self::DEFAULT_COLOR;
        $event->tools = self::TOOLS_ARE_NOT_READY;
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
        $fullname,
        $tools,
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
            $this->payment = self::STATUS_CASH;
        }
        $this->rate = $rate;
        $this->fullname = $fullname;
        $this->tools = $tools;
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
        $fullname,
        $tools,
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
        $event->fullname = $fullname;
        $event->tools = $tools;
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

    public function isToolsAreNotReady():bool
    {
        return $this->tools == self::TOOLS_ARE_NOT_READY;
    }

    public function toolsReady():int
    {
        return $this->tools = self::TOOLS_READY;
    }

    public function assignService($serviceId, $serviceCost, $priceRate, $priceCost): void
    {
        $assignments = $this->serviceAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForEvent($serviceId)) {
                return;
            }
        }
        $assignments[] = ServiceAssignment::create($serviceId, $serviceCost, $priceRate, $priceCost);
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
        /*if ($this->employee){
            return $this->employee->rate->rate;
        }*/
        return $this->rate;
    }
    public function attributeLabels()
    {
        return [
            'master_id' => tHelper::translate('schedule/event','Master'),
            'client_id' => tHelper::translate('schedule/event','Client'),
            'service' => tHelper::translate('schedule/event','Services'),
            'status' => tHelper::translate('schedule/event','Status'),
            'start' => tHelper::translate('schedule/event','Start'),
            'end' => tHelper::translate('schedule/event','End'),
            'payment' => tHelper::translate('schedule/event','Payment'),
            'cost' => tHelper::translate('schedule/event','Cost'),
            'notice' => tHelper::translate('schedule/event','Notice'),
            'amount' => tHelper::translate('schedule/event','Amount'),
            'tools' => tHelper::translate('schedule/event','Tools'),
        ];
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
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
                //'value' => new Expression('NOW()'),
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