<?php


namespace core\forms\manage\User;


use core\entities\User\User;
use core\forms\CompositeForm;
use core\forms\manage\ScheduleForm;
use core\helpers\tHelper;

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
    public $status;

    public $_user;


    public function __construct(User $user, $config = [])
    {
        if ($user){
            $this->username = $user->username;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->password = $user->password;
            $this->status = $user->status;
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
            ['status', 'integer'],
            [['username','email','phone','notice'],'string','max'=>255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
            ['password','string','min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>tHelper::t('user','Username'),
            'email'=>tHelper::t('user','Email'),
            'phone'=>tHelper::t('user','Phone'),
            'notice'=>tHelper::t('user','Notice'),
            'status'=>tHelper::t('user','Status'),
            'password'=>tHelper::t('user','Password'),
        ];
    }

    protected function internalForms(): array
    {
        return ['schedule' ];
    }
}