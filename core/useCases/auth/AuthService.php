<?php


namespace core\useCases\auth;


use core\entities\User\User;
use core\forms\auth\LoginForm;
use core\helpers\tHelper;
use core\helpers\UserHelper;
use core\repositories\UserRepository;

class AuthService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->users->findByUsernameOrEmail($form->username);

        if (!$user || !$user->employee || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException(tHelper::translate('login', 'error'));
        }
        return $user;
    }

    public function authAdmin(LoginForm $form): User
    {
        $user = $this->users->findByUsernameOrEmail($form->username);

        foreach (['admin', 'manager'] as $item) {
            $role = UserHelper::hasRole($item, $user->id);
            if ($item == $role) {
                return $user;
            }
        }

        if (!$user || !$user->employee || !$role || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException(tHelper::translate('login', 'permission'));
        }
        return $user;
    }
}