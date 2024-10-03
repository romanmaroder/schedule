<?php


namespace core\forms\manage\User;


use core\entities\User\User;
use core\helpers\tHelper;
use yii\base\Model;


class UserEmployeeCreateForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $notice;


    public function rules()
    {
        return [
            [['username','notice'],'safe'],
            ['email','email'],
            [['username','email','phone','notice'],'string','max'=>255],
            [['username'],'unique','targetClass' => User::class],
            ['password','string','min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => tHelper::translate('user','Username'),
            'notice' => tHelper::translate('user','Notice'),
            'email' => tHelper::translate('user','Email'),
            'phone' => tHelper::translate('user','Phone'),
            'password' => tHelper::translate('user','Password'),
        ];
    }
}