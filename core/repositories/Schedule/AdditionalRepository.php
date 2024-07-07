<?php


namespace core\repositories\Schedule;


use core\entities\Schedule\Additional\Additional;
use core\repositories\NotFoundException;

class AdditionalRepository
{
    public function get($id): Additional
    {
        if (!$service = Additional::findOne($id)) {
            throw new NotFoundException('Service is not found.');
        }
        return $service;
    }

    public function existsByMainCategory($id):bool
    {
        return Additional::find()->andWhere(['category_id'=>$id])->exists();
    }

    public function save(Additional $service): void
    {
        if (!$service->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Additional $service): void
    {
        if (!$service->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}