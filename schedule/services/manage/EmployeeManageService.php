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

class EmployeeManageService
{
    private EmployeeRepository $repository;
    private UserRepository $users;

    public function __construct(EmployeeRepository $repository, UserRepository $users)
    {
        $this->repository = $repository;
        $this->users = $users;
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
                $form->schedule->weekends
            ),
            $form->color,
            $form->roleId,
            $form->status
        );
        $this->repository->save($employee);
    }

    public function edit($id, EmployeeEditForm $form): void
    {
        $user = $this->users->get($form->userId);
        $user->edit(
            $user->username = $user->mergeFullName([$form->firstName, $form->lastName]),
            $user->email =$form->user->email,
            $user->phone = $form->user->phone,
            $user->password = $form->user->password,
            new Schedule(
                $form->schedule->hoursWork,
                $form->schedule->weekends,
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
            ),
            $form->color,
            $form->roleId,
            $form->status,
        );
        $this->repository->save($employee);
        $this->users->save($user);
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
            ),
            $form->color,
            $form->roleId,
            $form->status
        );
        $this->users->save($user);
    }

    public function remove($id): void
    {
        $employee = $this->repository->get($id);
        $this->repository->remove($employee);
    }

}