<?php


namespace core\useCases\manage;


use core\entities\Schedule;
use core\entities\User\User;
use core\forms\manage\User\UserCreateForm;
use core\forms\manage\User\UserEditForm;
use core\repositories\EmployeeRepository;
use core\repositories\UserRepository;
use core\services\newsletter\Newsletter;
use core\services\RoleManager;
use core\services\TransactionManager;

class UserManageService
{
    private UserRepository $users;
    private $employee;
    private $roles;
    private $transaction;

    /**
     * @var Newsletter
     */
    private $newsletter;

    public function __construct(UserRepository $users,
        EmployeeRepository $employee,
        RoleManager $roles,
        TransactionManager $transaction,
        /*Newsletter $newsletter*/
    )
    {
        $this->users = $users;
        $this->employee = $employee;
        $this->transaction = $transaction;
        $this->roles = $roles;
        /*$this->newsletter = $newsletter;*/
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
        $this->transaction->wrap(function () use ($user, $form) {
            $this->users->save($user);
            //$this->newsletter->subscribe($user->email);
        });
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
        $this->transaction->wrap(function () use ($user, $form) {
            $this->users->save($user);
        });

    }

    public function assignRole($id, $role): void
    {
        $user = $this->users->get($id);
        $this->roles->assign($user->id, $role);
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
            //$this->newsletter->unsubscribe($user->email);
    }
}