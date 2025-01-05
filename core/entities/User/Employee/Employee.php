<?php


namespace core\entities\User\Employee;


use core\entities\Address;
use core\entities\behaviors\AddressBehavior;
use core\entities\behaviors\ScheduleWorkBehavior;
use core\entities\Enums\EmployeeStatusEnum;
use core\entities\Schedule;
use core\entities\Schedule\Event\Event;
use core\entities\User\Employee\queries\EmployeeQuery;
use core\entities\User\Price;
use core\entities\User\Rate;
use core\entities\User\Role;
use core\entities\User\User;
use core\helpers\DateHelper;
use core\helpers\tHelper;
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
 * @property EmployeeStatusEnum $status
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
        $employee->status = EmployeeStatusEnum::STATUS_INACTIVE->value;
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
        $employee->status = EmployeeStatusEnum::STATUS_ACTIVE->value;
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

    public function editProfile(
        string $firstName,
        string $lastName,
        string $phone,
        string $birthday,
        Address $address
    ): void {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->phone = $phone;
        $this->birthday = $birthday;
        $this->address = $address;
    }

    public function isActive(): bool
    {
        return $this->status == EmployeeStatusEnum::STATUS_ACTIVE;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getFullAddress(): string
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

    public function issetBirthday($birthday): bool
    {
        if (!$birthday) {
            return false;
        }
        return true;
    }

    public function isBirthday(): bool
    {
        $today = DateHelper::formatterDate(new \DateTime());
        $birthday = DateHelper::formatterDate($this->birthday);
        if ($today === $birthday) {
            return true;
        }
        return false;
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

    public function attributeLabels(): array
    {
        return [
            'user_id'=>tHelper::translate('user/employee','User Id'),
            'rate_id'=>tHelper::translate('user/employee','Rate Id'),
            'price_id'=>tHelper::translate('user/employee','Price Id'),
            'first_name'=>tHelper::translate('user/employee','First Name'),
            'last_name'=>tHelper::translate('user/employee','Last Name'),
            'phone'=>tHelper::translate('user/employee','Phone'),
            'employee.phone'=>tHelper::translate('user/employee','Employee phone number'),
            'birthday'=>tHelper::translate('user/employee','Birthday'),
            'color'=>tHelper::translate('user/employee','Color'),
            'role_id'=>tHelper::translate('user/employee','Role Id'),
            'status'=>tHelper::translate('user/employee','Status'),
            'role'=>tHelper::translate('user/employee','Role'),
            'rate'=>tHelper::translate('user/employee','Rate'),
            'price'=>tHelper::translate('user/employee','Price'),
            'schedule.hours'=>tHelper::translate('user/schedule','Hours'),
            'schedule.weekends'=>tHelper::translate('user/schedule','Weekends'),
            'address.home'=>tHelper::translate('user/schedule','home'),
            'address.town'=>tHelper::translate('user/address','town'),
            'address.borough'=>tHelper::translate('user/address','borough'),
            'address.apartment'=>tHelper::translate('user/address','apartment'),
            'address.street'=>tHelper::translate('user/address','street'),
        ];
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