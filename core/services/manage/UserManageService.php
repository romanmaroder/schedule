<?php


namespace core\services\manage;


use core\entities\Schedule;
use core\entities\User\User;
use core\forms\manage\User\UserCreateForm;
use core\forms\manage\User\UserEditForm;
use core\repositories\EmployeeRepository;
use core\repositories\UserRepository;

class UserManageService
{
    private UserRepository $users;
    private $employee;

    public function __construct(UserRepository $users, EmployeeRepository $employee)
    {
        $this->users = $users;
        $this->employee = $employee;
    }

    /**
     * @param UserCreateForm $form
     * @return User
     */
    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->phone,
            $form->password,
            new Schedule(
                $form->schedule->hoursWork,
                $form->schedule->weekends,
                $form->schedule->week,
            ),
            $form->notice,
        );
        $this->users->save($user);
        return $user;
    }

    /**
     * @param $id
     * @param UserEditForm $form
     */
    public function edit($id, UserEditForm $form): void
    {
        $user = $this->users->get($id);
        $user->edit(
            $form->username,
            $form->email,
            $form->phone,
            $form->password,
            $form->status,
            new Schedule(
                $form->schedule->hoursWork,
                $form->schedule->weekends,
                $form->schedule->week,
            ),
            $form->notice,
        );
        $this->users->save($user);
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id): void
    {
            $user = $this->users->get($id);
            $this->users->remove($user);
    }
}