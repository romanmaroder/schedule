<?php


namespace schedule\forms\manage\User;


use schedule\entities\User\User;
use yii\base\Model;


class UserCreateForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $discount;
    public $password;



    public function rules()
    {
        return [
            [['username'],'required'],
            ['email','email'],
            ['discount','integer'],
            [['username','email','phone'],'string','max'=>255],
            [['username','email'],'unique','targetClass' => User::class],
            ['password','string','min' => 6],
        ];
    }
}