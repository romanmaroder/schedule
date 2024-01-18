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


    public function rules()
    {
        return [
            [['username'],'safe'],
            ['email','email'],
            [['username','email','phone'],'string','max'=>255],
            [['username','email'],'unique','targetClass' => User::class],
            ['password','string','min' => 6],
        ];
    }
}