<?php


namespace schedule\repositories;


use schedule\entities\User\Employee\Employee;

class EmployeeRepository
{
    public function get($id): Employee
    {
        return Employee::find()->andWhere(['id' => $id])->one();
    }

    public function checkEvent($id):bool
    {

        if ($employee = Employee::find()->joinWith('events e')->andWhere(['e.master_id' => $id])->one()) {
            throw new \RuntimeException($employee->getFullName() . ' have events');
        }
        return false;
    }

    public function save(Employee $employee): void
    {
        if (!$employee->save()) {
            throw new \RuntimeException('Saving error.');
        }

    }

    public function remove(Employee $employee): void
    {
        $this->checkEvent($employee->user_id);

        if (!$employee->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}