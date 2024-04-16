<?php


namespace schedule\entities\User\Employee;


use schedule\entities\Address;
use schedule\entities\behaviors\AddressBehavior;
use schedule\entities\behaviors\ScheduleWorkBehavior;
use schedule\entities\Schedule;
use schedule\entities\Schedule\Event\Event;
use schedule\entities\User\Employee\queries\EmployeeQuery;
use schedule\entities\User\Price;
use schedule\entities\User\Rate;
use schedule\entities\User\Role;
use schedule\entities\User\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Employee model
 *
 * @property int $id
 * @property int $user_id
 * @property int $rate_id
 * @property int $price_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $birthday
 * @property string $address_json
 * @property string $color
 * @property string $role_id
 * @property int $status
 * @property Address $address
 * @property Schedule $schedule
 * @property User $user
 * @property Role $role
 * @property Rate $rate
 * @property Price $price
 * @property string $schedule_json [json]
 */
class Employee extends ActiveRecord
{
    public $address;
    public $schedule;

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;


    public static function attach(
        $rateId,
        $priceId,
        $firstName,
        $lastName,
        $phone,
        $birthday,
        Address $address,
        Schedule $schedule,
        $color,
        $roleId,
        $status
    ): self {
        $employee = new static();
        $employee->rate_id = $rateId;
        $employee->price_id = $priceId;
        $employee->first_name = $firstName;
        $employee->last_name = $lastName;
        $employee->phone = $phone;
        $employee->birthday = $birthday;
        $employee->address = $address;
        $employee->schedule = $schedule;
        $employee->color = $color;
        $employee->role_id = $roleId;
        $employee->status = self::STATUS_INACTIVE;
        return $employee;
    }

    public static function create(
        $userId,
        $rateId,
        $priceId,
        $firstName,
        $lastName,
        $phone,
        $birthday,
        Address $address,
        Schedule $schedule,
        $color,
        $roleId,
        $status
    ): self {
        $employee = new static();
        $employee->user_id = $userId;
        $employee->rate_id = $rateId;
        $employee->price_id = $priceId;
        $employee->first_name = $firstName;
        $employee->last_name = $lastName;
        $employee->phone = $phone;
        $employee->birthday = $birthday;
        $employee->address = $address;
        $employee->schedule = $schedule;
        $employee->color = $color;
        $employee->role_id = $roleId;
        $employee->status = self::STATUS_ACTIVE;
        return $employee;
    }

    public function edit(
        $rateId,
        $priceId,
        $firstName,
        $lastName,
        $phone,
        $birthday,
        Address $address,
        Schedule $schedule,
        $color,
        $roleId,
        $status
    ) {
        $this->rate_id = $rateId;
        $this->price_id = $priceId;
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->phone = $phone;
        $this->birthday = $birthday;
        $this->address = $address;
        $this->schedule = $schedule;
        $this->color = $color;
        $this->role_id = $roleId;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getFullAddress()
    {
        return $this->address->town . PHP_EOL . $this->address->borough . PHP_EOL . $this->address->street . PHP_EOL
            . $this->address->home . PHP_EOL . $this->address->apartment;
    }

    public function issetAddress($address): bool
    {
        if (!$address) {
            return false;
        }
        return true;
    }

    public function issetBirthday($birthday)
    {
        if (!$birthday) {
            return false;
        }
        return true;
    }

    public function getHours()
    {
        return $this->schedule->hoursWork;
    }

    public function getWeekends()
    {
        return $this->schedule->weekends;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getRole(): ActiveQuery
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    public function getRate(): ActiveQuery
    {
        return $this->hasOne(Rate::class, ['id' => 'rate_id']);
    }
    public function getPrice(): ActiveQuery
    {
        return $this->hasOne(Price::class, ['id' => 'price_id']);
    }

    public function getEvents(): ActiveQuery
    {
        return $this->hasMany(Event::class, ['master_id' => 'user_id']);
    }

    public static function tableName(): string
    {
        return '{{%schedule_employees}}';
    }

    public function behaviors(): array
    {
        return [
            AddressBehavior::class,
            ScheduleWorkBehavior::class
        ];
    }

    public static function find():EmployeeQuery
    {
        return new EmployeeQuery(static::class);
    }
}