<?php


namespace core\listeners\Shop\Category;


use core\entities\Shop\Product\Category;
use core\repositories\events\EntityPersisted;
use yii\caching\Cache;
use yii\caching\TagDependency;

class CategoryPersistenceListener
{
    private $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function handle(EntityPersisted $event): void
    {
        if ($event->entity instanceof Category) {
            TagDependency::invalidate($this->cache, ['categories']);
        }
    }
}