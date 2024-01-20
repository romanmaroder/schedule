<?php


namespace schedule\forms\manage\User\Employee;


use schedule\forms\CompositeForm;
use schedule\forms\manage\AddressForm;
use schedule\forms\manage\User\UserEmployeeCreateForm;

/**
 * @property AddressForm $address
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


    public function __construct($config = [])
    {
        $this->address = new AddressForm();
        $this->user = new UserEmployeeCreateForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['rateId', 'priceId', 'roleId', 'firstName', 'lastName'], 'required'],
            [['firstName', 'lastName'], 'string', 'max' => 100],
            [['birthday', 'phone', 'color'], 'string'],
            [['status', 'roleId'], 'integer'],
        ];
    }

    protected function internalForms(): array
    {
        return ['address', 'user'];
    }
}