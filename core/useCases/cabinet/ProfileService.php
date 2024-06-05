<?php


namespace core\useCases\cabinet;


use core\entities\Address;
use core\forms\user\ProfileEditForm;
use core\repositories\EmployeeRepository;
use core\repositories\UserRepository;

class ProfileService
{
    private EmployeeRepository $employees;
    private UserRepository $users;

    public function __construct(EmployeeRepository $employees, UserRepository $users)
    {
        $this->employees = $employees;
        $this->users = $users;
    }

    public function edit($id, ProfileEditForm $form): void
    {
        $employee = $this->employees->get($id);
        $user = $employee->user;

        $employee->editProfile(
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
        );
        $user->editProfile(
            [$form->firstName, $form->lastName],
            $form->email,
            $form->password
        );

        $this->employees->save($employee);
        $this->users->save($user);
    }
}