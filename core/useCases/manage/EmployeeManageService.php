<?php


namespace core\useCases\manage;


use core\entities\Address;
use core\entities\Schedule;
use core\entities\User\Employee\Employee;
use core\entities\User\User;
use core\forms\manage\User\Employee\EmployeeCreateForm;
use core\forms\manage\User\Employee\EmployeeEditForm;
use core\forms\manage\User\Employee\EmployeeExistCreateForm;
use core\repositories\EmployeeRepository;
use core\repositories\UserRepository;
use core\services\RoleManager;
use core\services\TransactionManager;

class EmployeeManageService
{
    private EmployeeRepository $repository;
    private UserRepository $users;
    private $roles;
    private $transaction;

    public function __construct(
        EmployeeRepository $repository,
        UserRepository $users,
        RoleManager $roles,
        TransactionManager $transaction
    ) {
        $this->repository = $repository;
        $this->users = $users;
        $this->roles = $roles;
        $this->transaction = $transaction;
    }

    public function create(EmployeeExistCreateForm $form): void
    {
        $user = $this->users->get($form->userId);
        $username = $user->parseFullName($user->username);

        $employee = Employee::create(
            $form->userId,
            $form->rateId,
            $form->priceId,
            $form->firstName = $username[0] ?? 'No first name',
            $form->lastName = $username[1] ?? 'No last name',
            $form->phone,
            $form->birthday,
            new Address(
                $form->address->town,
                $form->address->borough,
                $form->address->street,
                $form->address->home,
                $form->address->apartment,
            ),
            new Schedule(
                $form->schedule->hoursWork,
                $form->schedule->weekends,
                $form->schedule->week
            ),
            $form->color,
            $form->roleId,
            $form->status
        );

        $this->transaction->wrap(
            function () use ($employee, $form) {
                $this->repository->save($employee);
                $this->roles->assign($employee->user_id, $form->role);
            }
        );
    }

    public function edit($id, EmployeeEditForm $form): void
    {
        $user = $this->users->get($form->userId);
        $user->edit(
            $user->username = $user->mergeFullName([$form->firstName, $form->lastName]),
            $user->email =$form->user->email,
            $user->phone = $form->user->phone,
            $user->password = $form->user->password,
            $user->status = $form->user->status,
            new Schedule(
                $form->schedule->hoursWork,
                $form->schedule->weekends,
                $form->schedule->week,
            ),
            $user->notice = $form->user->notice,
        );

        $employee = $this->repository->get($id);
        $employee->edit(
            $form->rateId,
            $form->priceId,
            $form->firstName,
            $form->lastName,
            $form->phone,
            $form->birthday,
            new Address(
                $form->address->town,
                $form->address->borough,
                $form->address->street,
                $form->address->home,
                $form->address->apartment,
            ),
            new Schedule(
                $form->schedule->hoursWork,
                $form->schedule->weekends,
                $form->schedule->week,
            ),
            $form->color,
            $form->roleId,
            $form->status,
        );
        $this->transaction->wrap(
            function () use ($employee, $form, $user) {
                $this->users->save($user);
                $this->roles->assign($employee->user_id, $form->role);
                $this->repository->save($employee);
            }
        );
    }

    public function attach(EmployeeCreateForm $form)
    {
        $user = User::create(
            $form->user->username = $form->firstName . ' ' . $form->lastName,
            $form->user->email,
            $form->phone,
            $form->user->password,
            new Schedule(
                $form->schedule->hoursWork,
                $form->schedule->weekends,
                $form->schedule->week,
            ),
            $form->user->notice,
        );

        $user->attachEmployee(
            $form->rateId,
            $form->priceId,
            $form->firstName,
            $form->lastName,
            $form->phone,
            $form->birthday,
            new Address(
                $form->address->town,
                $form->address->borough,
                $form->address->street,
                $form->address->home,
                $form->address->apartment,
            ),new Schedule(
                $form->schedule->hoursWork,
                $form->schedule->weekends,
                $form->schedule->week,
            ),
            $form->color,
            $form->roleId,
            $form->status
        );
        $this->users->save($user);
    }

    public function assignRole($id, $role): void
    {
        $employee = $this->repository->get($id);
        $this->roles->assign($employee->user_id, $role);
    }

    public function remove($id): void
    {
        $employee = $this->repository->get($id);
        $this->roles->revoke($employee->user_id);
        $this->repository->remove($employee);
    }

}