<?php


namespace core\forms\user;


use core\entities\User\Employee\Employee;
use core\entities\User\User;
use core\forms\CompositeForm;
use core\forms\manage\AddressForm;
use core\forms\manage\ScheduleForm;


/**
 * @property AddressForm $address
 * @property ScheduleForm $core
 */
class ProfileEditForm extends CompositeForm
{

    public $firstName;
    public $lastName;
    public $phone;
    public $birthday;
    public $email;
    public $password;


    public $_employee;

    public function __construct(Employee $employee, $config = [])
    {
        $this->firstName = $employee->first_name;
        $this->lastName = $employee->last_name;
        $this->phone = $employee->phone;
        $this->birthday = $employee->birthday;
        $this->address = new AddressForm($employee->address);
        $this->email = $employee->user->email;
        $this->password = $employee->user->password;
        $this->_employee = $employee;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['firstName', 'lastName', 'birthday'], 'string'],
            ['email', 'email'],
            [['email'], 'string', 'max' => 255],
            [['phone'], 'string'],
            [['email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_employee->user_id]],
            ['password', 'string', 'min' => 6],
        ];
    }

    protected function internalForms(): array
    {
        return ['address'];
    }
}