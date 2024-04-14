<?php


namespace schedule\forms\manage\User;


use schedule\entities\User\User;
use schedule\forms\CompositeForm;
use schedule\forms\manage\ScheduleForm;

/**
 * @property ScheduleForm $schedule
 */
class UserCreateForm extends CompositeForm
{
    public $username;
    public $email;
    public $phone;
    public $password;

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
            [['username','email','phone'],'string','max'=>255],
            [['username','email'],'unique','targetClass' => User::class],
            ['password','string','min' => 6],
        ];
    }

    protected function internalForms(): array
    {
        return ['schedule'];
    }
}