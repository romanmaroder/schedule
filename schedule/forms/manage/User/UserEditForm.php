<?php


namespace schedule\forms\manage\User;


use schedule\entities\User\User;
use schedule\forms\CompositeForm;
use schedule\forms\manage\ScheduleForm;
use yii\base\Model;

/**
 * @property ScheduleForm $schedule
 */

class UserEditForm extends CompositeForm
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $notice;

    public $_user;


    public function __construct(User $user, $config = [])
    {
        if ($user){

            $this->username = $user->username;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->password = $user->password;
            $this->schedule = new ScheduleForm($user->schedule);
            $this->notice = $user->notice;
            $this->_user = $user;
        }else{
            $this->schedule = new ScheduleForm();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username'], 'required'],
            ['email', 'email'],
            [['username','email','phone','notice'],'string','max'=>255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
            ['password','string','min' => 6],
        ];
    }

    protected function internalForms(): array
    {
        return ['schedule' ];
    }
}