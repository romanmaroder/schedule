<?php

namespace core\forms\auth;

use core\entities\Enums\UserStatusEnum;
use core\entities\User\User;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    /**
     * @var string
     */
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => UserStatusEnum::STATUS_INACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

}
