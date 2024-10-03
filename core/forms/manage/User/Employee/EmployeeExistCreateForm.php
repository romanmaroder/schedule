<?php


namespace core\forms\manage\User\Employee;


use core\entities\User\User;
use core\forms\CompositeForm;
use core\forms\manage\AddressForm;
use core\forms\manage\ScheduleForm;
use core\helpers\tHelper;
use yii\helpers\ArrayHelper;

/**
 * @property AddressForm $address
 * @property ScheduleForm $schedule
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
    public $role;


    public function __construct($config = [])
    {
        $this->address = new AddressForm();
        $this->schedule = new ScheduleForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['userId', 'rateId','roleId', 'priceId','role'], 'required'],
            [['firstName', 'lastName'], 'safe'],
            [['birthday', 'phone','color'], 'string'],
            [['userId', 'status','rateId','roleId', 'priceId'], 'integer'],
            [['firstName', 'lastName'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
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

    public function userList(): array
    {
       return ArrayHelper::map( User::find()
           ->leftJoin('schedule_employees','schedule_employees.user_id=users.id')
           ->where(['is','schedule_employees.user_id',null])->asArray()->all(),'id','username');
    }

    public function rolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    protected function internalForms(): array
    {
        return ['address','schedule'];
    }
}