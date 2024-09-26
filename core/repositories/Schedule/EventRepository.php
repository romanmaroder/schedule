<?php


namespace core\repositories\Schedule;


use core\dispatchers\EventDispatcher;
use core\entities\Schedule\Event\Event;
use core\repositories\events\EntityPersisted;
use core\repositories\events\EntityRemoved;
use core\repositories\NotFoundException;
use core\useCases\Schedule\CacheService;
use yii\caching\TagDependency;

class EventRepository
{
    private $dispatcher;
    private $cacheService;

    public function __construct(EventDispatcher $dispatcher,CacheService $cacheService)
    {
        $this->dispatcher = $dispatcher;
        $this->cacheService = $cacheService;
    }

    public function get($id): Event
    {
        if (!$event = Event::findOne($id)){
            throw new NotFoundException('Event is not found.');
        }

        return $event;
    }

    public function getLastId(): Event
    {
        return Event::find()->orderBy('id DESC')->one();
    }

    public function save(Event $event):void
    {
        if (!$event->save()){
            throw new \RuntimeException('Saving error.');
        }
       // $this->dispatcher->dispatch(new EntityPersisted($event));
        //TagDependency::invalidate(\Yii::$app->cache, ['event']);
        $this->cacheService->deleteTag(Event::CACHE_KEY);
    }

    public function remove(Event $event):void
    {
        if (!$event->delete()){
            throw new \RuntimeException('Removing error.');
        }
       //$this->dispatcher->dispatch(new EntityRemoved($event));
        //TagDependency::invalidate(\Yii::$app->cache, ['event']);
        $this->cacheService->deleteTag(Event::CACHE_KEY);
    }

}