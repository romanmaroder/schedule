<?php


namespace schedule\services\manage;


use schedule\entities\Schedule;
use schedule\entities\User\User;
use schedule\forms\manage\User\UserCreateForm;
use schedule\forms\manage\User\UserEditForm;
use schedule\repositories\EmployeeRepository;
use schedule\repositories\UserRepository;

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
                $form->schedule->weekends
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
            new Schedule(
                $form->schedule->hoursWork,
                $form->schedule->weekends,
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