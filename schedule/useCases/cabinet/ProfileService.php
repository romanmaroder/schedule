<?php


namespace schedule\useCases\cabinet;


use schedule\entities\Address;
use schedule\forms\user\ProfileEditForm;
use schedule\repositories\EmployeeRepository;
use schedule\repositories\UserRepository;

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
        $user->editProfile([$form->firstName, $form->lastName], $form->email, $form->password);

        $this->employees->save($employee);
        $this->users->save($user);
    }
}