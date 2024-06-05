<?php


namespace core\repositories\Expenses;


use core\entities\Expenses\Expenses\Expenses;
use core\repositories\NotFoundException;

class ExpenseRepository
{
    public function get($id): Expenses
    {
        if (!$service = Expenses::findOne($id)) {
            throw new NotFoundException('Service is not found.');
        }
        return $service;
    }

    public function existsByMainCategory($id):bool
    {
        return Expenses::find()->andWhere(['category_id'=>$id])->exists();
    }

    public function save(Expenses $service): void
    {
        if (!$service->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Expenses $service): void
    {
        if (!$service->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}