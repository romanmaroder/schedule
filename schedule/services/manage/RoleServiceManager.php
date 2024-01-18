<?php


namespace schedule\services\manage;


use schedule\entities\User\Role;
use schedule\forms\manage\User\Role\RoleForm;
use schedule\repositories\RoleRepository;

class RoleServiceManager
{
    private RoleRepository $roles;

    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
    }

    public function create(RoleForm $form): Role
    {
        $role = Role::create($form->name);
        $this->roles->save($role);
        return $role;
    }

    public function edit($id, RoleForm $form): void
    {
        $role = $this->roles->get($id);
        $role->edit($form->name);
        $this->roles->save($role);
    }

    public function remove($id): void
    {
        $role = $this->roles->get($id);
        $this->roles->remove($role);
    }
}