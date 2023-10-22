<?php


namespace schedule\repositories\Schedule;


use schedule\entities\Schedule\Service\Service;
use schedule\repositories\NotFoundException;

class ServiceRepository
{
    public function get($id): Service
    {
        if (!$service = Service::findOne($id)) {
            throw new NotFoundException('Service is not found.');
        }
        return $service;
    }

    public function save(Service $service): void
    {
        if (!$service->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Service $service): void
    {
        if (!$service->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}