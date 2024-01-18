<?php


namespace schedule\forms\manage\User\Employee;


use schedule\entities\User\User;
use schedule\forms\CompositeForm;
use schedule\forms\manage\AddressForm;
use yii\helpers\ArrayHelper;

/**
 * @property AddressForm $address
 */
class EmployeeExistCreateForm extends CompositeForm
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

    public function __construct($config = [])
    {
        $this->address = new AddressForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['userId', 'rateId','roleId', 'priceId'], 'required'],
            [['firstName', 'lastName'], 'safe'],
            [['birthday', 'phone','color'], 'string'],
            [['userId', 'status','rateId','roleId', 'priceId'], 'integer'],
            [['firstName', 'lastName'], 'string', 'max' => 100],
        ];
    }

    public function userList(): array
    {
       return ArrayHelper::map( User::find()
           ->leftJoin('schedule_employees','schedule_employees.user_id=users.id')
           ->where(['is','schedule_employees.user_id',null])->asArray()->all(),'id','username');
    }


    protected function internalForms(): array
    {
        return ['address'];
    }
}