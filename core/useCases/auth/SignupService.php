<?php


namespace core\useCases\auth;


use core\entities\User\User;
use core\forms\auth\SignupForm;
use core\repositories\UserRepository;
use core\services\TransactionManager;
use yii\base\InvalidArgumentException;

class SignupService
{
    private $users;
    private $transaction;

    public function __construct(UserRepository $users,
        TransactionManager $transaction,
    )
    {
        $this->users = $users;
        $this->transaction = $transaction;
    }

    public function signup(SignupForm $form): void
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );

        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
        });
    }

    public function confirm($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }

        $user = $this->users->getByVerificationToken($token);
        $user->verifyEmail();
        $this->users->save($user);
    }
}