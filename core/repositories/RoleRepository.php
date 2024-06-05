<?php


namespace core\repositories;


use core\entities\User\Role;

class RoleRepository
{
    /**
     * @param $id
     * @return Role
     */
    public function get($id): Role
    {
        return $this->getBy(['id' => $id]);
    }


    /**
     * @param Role $role
     */
    public function save(Role $role): void
    {
        if (!$role->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param Role $role
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Role $role):void
    {
        if (!$role->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    /**
     * @param array $condition
     * @return Role
     */
    private function getBy(array $condition): Role
    {
        if (!$role = Role::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('User not found.');
        }
        return $role;
    }
}