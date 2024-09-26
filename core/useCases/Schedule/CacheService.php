<?php


namespace core\useCases\Schedule;


use yii\caching\Cache;
use yii\caching\TagDependency;

class CacheService
{
    public $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function deleteTag($tag)
    {
        TagDependency::invalidate($this->cache, $tag);
    }

    public function flush()
    {
        $this->cache->flush();
    }
}