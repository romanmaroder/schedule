<?php


namespace schedule\forms\manage\User\Employee;


use schedule\entities\User\Employee\Employee;
use schedule\forms\CompositeForm;
use schedule\forms\manage\AddressForm;
use schedule\forms\manage\User\UserEditForm;

/**
 * @property AddressForm $address
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
            $this->color = $employee->color;
            $this->roleId = $employee->role_id;
            $this->status = $employee->status;
            $this->_employee = $employee;
        }else{
            $this->address = new AddressForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['userId','rateId', 'priceId', 'firstName', 'lastName'], 'required'],
            [['firstName', 'lastName'], 'string', 'max' => 100],
            [['color','birthday','phone'],'string'],
            [['roleId'],'integer'],
        ];
    }

    protected function internalForms(): array
    {
        return ['address', 'user'];
    }

}