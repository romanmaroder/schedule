<?php


namespace schedule\forms\manage\User;


use schedule\entities\User\User;
use yii\base\Model;


class UserEmployeeCreateForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $discount;
    public $password;


    public function rules()
    {
        return [
            [['username'],'safe'],
            ['email','email'],
            ['discount','integer'],
            [['username','email','phone'],'string','max'=>255],
            [['username'],'unique','targetClass' => User::class],
            ['password','string','min' => 6],
        ];
    }
}