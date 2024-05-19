<?php


namespace schedule\services\manage;


use schedule\entities\Address;
use schedule\entities\Schedule;
use schedule\entities\User\Employee\Employee;
use schedule\entities\User\User;
use schedule\forms\manage\User\Employee\EmployeeCreateForm;
use schedule\forms\manage\User\Employee\EmployeeEditForm;
use schedule\forms\manage\User\Employee\EmployeeExistCreateForm;
use schedule\repositories\EmployeeRepository;
use schedule\repositories\UserRepository;
use schedule\services\RoleManager;
use schedule\services\TransactionManager;

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
                $this->repository->save($employee);
                $this->roles->assign($employee->user_id, $form->role);
                $this->users->save($user);
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