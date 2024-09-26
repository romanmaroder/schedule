<?php


namespace core\listeners\Schedule\Event;


use core\entities\Schedule\Event\Event;
use core\repositories\events\EntityPersisted;
use yii\caching\Cache;
use yii\caching\TagDependency;

class EventSearchPersistListener
{
    private $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function handle(EntityPersisted $event): void
    {
        if ($event->entity instanceof Event) {
            TagDependency::invalidate($this->cache, ['event']);
        }
    }
}
