<?php

namespace core\forms\auth;

use core\helpers\tHelper;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            [['username'],'string'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            //['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => tHelper::translate('user', 'Username'),
            'password' => tHelper::translate('user', 'Password'),

        ];
    }
}
