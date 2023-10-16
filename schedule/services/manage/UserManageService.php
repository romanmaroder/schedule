<?php


namespace schedule\services\manage;


use schedule\entities\User\User;
use schedule\forms\manage\User\UserCreateForm;
use schedule\repositories\UserRepository;

class UserManageService
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );
        $this->repository->save($user);
        return $user;
    }
}