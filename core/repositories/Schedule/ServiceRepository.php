<?php


namespace core\repositories\Schedule;


use core\entities\Schedule\Service\Service;
use core\repositories\NotFoundException;
use core\useCases\Schedule\CacheService;

class ServiceRepository
{
    private $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function get($id): Service
    {
        if (!$service = Service::findOne($id)) {
            throw new NotFoundException('Service is not found.');
        }
        return $service;
    }

    public function existsByMainCategory($id): bool
    {
        return Service::find()->andWhere(['category_id'=>$id])->exists();
    }

    public function save(Service $service): void
    {
        if (!$service->save()) {
            throw new \RuntimeException('Saving error.');
        }
        $this->cacheService->deleteTag(Service::CACHE_KEY);
    }

    public function remove(Service $service): void
    {
        if (!$service->delete()) {
            throw new \RuntimeException('Removing error.');
        }
        $this->cacheService->deleteTag(Service::CACHE_KEY);
    }
}