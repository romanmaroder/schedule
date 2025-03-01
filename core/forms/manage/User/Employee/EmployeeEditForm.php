<?php


namespace core\forms\manage\User\Employee;


use core\entities\User\Employee\Employee;
use core\forms\CompositeForm;
use core\forms\manage\AddressForm;
use core\forms\manage\ScheduleForm;
use core\forms\manage\User\UserEditForm;
use core\helpers\tHelper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property AddressForm $address
 * @property ScheduleForm $schedule
 * @property UserEditForm $user
 */
class EmployeeEditForm extends CompositeForm
{
    public $userId;
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

    private $_employee;

    public function __construct(Employee $employee = null, $config = [])
    {
        if ($employee) {
            $this->user = new UserEditForm($employee->user);
            $this->userId = $employee->user_id;
            $this->rateId = $employee->rate_id;
            $this->priceId = $employee->price_id;
            $this->firstName = $employee->first_name;
            $this->lastName = $employee->last_name;
            $this->phone = $employee->phone;
            $this->birthday = $employee->birthday;
            $this->address = new AddressForm($employee->address);
            $this->schedule = new ScheduleForm($employee->schedule);
            $this->color = $employee->color;
            $this->roleId = $employee->role_id;
            $this->status = $employee->status;
            $roles = Yii::$app->authManager->getRolesByUser($employee->user_id);
            $this->role = $roles ? reset($roles)->name : null;
            $this->_employee = $employee;
        }else{
            $this->address = new AddressForm();
            $this->schedule = new ScheduleForm();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['userId', 'rateId', 'priceId', 'firstName', 'lastName', 'role'], 'required'],
            [['firstName', 'lastName'], 'string', 'max' => 100],
            [['color', 'birthday', 'phone'], 'string'],
            [['roleId', 'status'], 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'userId'=>tHelper::translate('user/employee','User Id'),
            'rateId'=>tHelper::translate('user/employee','Rate Id'),
            'roleId'=>tHelper::translate('user/employee','Role Id'),
            'priceId'=>tHelper::translate('user/employee','Price Id'),
            'phone'=>tHelper::translate('user/employee','Phone'),
            'role'=>tHelper::translate('user/employee','Role'),
            'firstName'=>tHelper::translate('user/employee','First Name'),
            'lastName'=>tHelper::translate('user/employee','Last Name'),
            'birthday'=>tHelper::translate('user/employee','Birthday'),
            'status'=>tHelper::translate('user/employee','Status'),
            'color'=>tHelper::translate('user/employee','Color'),
        ];
    }

    public function rolesList(): array
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    protected function internalForms(): array
    {
        return ['address', 'schedule', 'user'];
    }

}