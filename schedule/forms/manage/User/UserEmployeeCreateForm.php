<?php


namespace schedule\forms\manage\User;


use schedule\entities\User\User;
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
}