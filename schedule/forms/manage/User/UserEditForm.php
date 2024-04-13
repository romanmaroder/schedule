<?php


namespace schedule\forms\manage\User;


use schedule\entities\User\User;
use yii\base\Model;



class UserEditForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;

    public $_user;


    public function __construct(User $user, $config = [])
    {
        if ($user){

            $this->username = $user->username;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->password = $user->password;
            $this->_user = $user;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username'], 'required'],
            ['email', 'email'],
            [['username','email','phone'],'string','max'=>255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
            ['password','string','min' => 6],
        ];
    }

}