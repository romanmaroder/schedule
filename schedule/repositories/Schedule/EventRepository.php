<?php


namespace schedule\repositories\Schedule;


use schedule\entities\Schedule\Event\Event;
use schedule\repositories\NotFoundException;

class EventRepository
{
    public function get($id): Event
    {
        if (!$event = Event::findOne($id)){
            throw new NotFoundException('Event is not found.');
        }

        return $event;
    }

    public function save(Event $event):void
    {
        if (!$event->save()){
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Event $event):void
    {
        if (!$event->delete()){
            throw new \RuntimeException('Removing error.');
        }
    }

}