<?php


namespace core\listeners\Schedule\Event;


use core\entities\Schedule\Event\Event;
use core\repositories\events\EntityRemoved;
use yii\caching\Cache;
use yii\caching\TagDependency;

class EventSearchRemoveListener
{
    private $cache;

    public function __construct( Cache $cache)
    {
        $this->cache = $cache;
    }

    public function handle(EntityRemoved $event): void
    {
        if ($event->entity instanceof Event) {
            TagDependency::invalidate($this->cache, ['event']);
        }
    }
}