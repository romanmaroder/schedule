<?php


namespace core\forms\manage\User\Employee;


use core\forms\CompositeForm;
use core\forms\manage\AddressForm;
use core\forms\manage\ScheduleForm;
use core\forms\manage\User\UserEmployeeCreateForm;
use core\helpers\tHelper;
use yii\helpers\ArrayHelper;

/**
 * @property AddressForm $address
 * @property ScheduleForm $schedule
 * @property UserEmployeeCreateForm $user
 */
class EmployeeCreateForm extends CompositeForm
{
    public $rateId;
    public $priceId;
    public $firstName;
    public $lastName;
    public $phone;
    public $birthday;
    public $color;
    public $roleId;
    public $status;
    public $role;


    public function __construct($config = [])
    {
        $this->address = new AddressForm();
        $this->schedule = new ScheduleForm();
        $this->user = new UserEmployeeCreateForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['rateId', 'priceId', 'roleId', 'firstName', 'lastName', 'role'], 'required'],
            [['firstName', 'lastName'], 'string', 'max' => 100],
            [['birthday', 'phone', 'color'], 'string'],
            [['status', 'roleId'], 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'userId' => tHelper::translate('user/employee', 'User Id'),
            'rateId' => tHelper::translate('user/employee', 'Rate Id'),
            'roleId' => tHelper::translate('user/employee', 'Role Id'),
            'priceId' => tHelper::translate('user/employee', 'Price Id'),
            'phone' => tHelper::translate('user/employee', 'Phone'),
            'role' => tHelper::translate('user/employee', 'Role'),
            'firstName' => tHelper::translate('user/employee', 'First Name'),
            'lastName' => tHelper::translate('user/employee', 'Last Name'),
            'birthday' => tHelper::translate('user/employee', 'Birthday'),
            'status' => tHelper::translate('user/employee', 'Status'),
            'color' => tHelper::translate('user/employee', 'Color'),
        ];
    }

    public function rolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    protected function internalForms(): array
    {
        return ['address', 'schedule', 'user'];
    }
}