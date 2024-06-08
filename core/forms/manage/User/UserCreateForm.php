<?php


namespace core\forms\manage\User;


use core\entities\User\User;
use core\forms\CompositeForm;
use core\forms\manage\ScheduleForm;

/**
 * @property ScheduleForm $schedule
 */
class UserCreateForm extends CompositeForm
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $notice;
    public $status;

    public function __construct($config = [])
    {
        $this->schedule = new ScheduleForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['username'],'required'],
            ['email','email'],
            ['status','integer'],
            [['username','email','phone','notice'],'string','max'=>255],
            [['username','email'],'unique','targetClass' => User::class],
            ['password','string','min' => 6],
        ];
    }

    protected function internalForms(): array
    {
        return ['schedule'];
    }
}