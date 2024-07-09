<?php


namespace core\repositories\Schedule;


use core\entities\Schedule\Event\FreeTime;
use core\repositories\NotFoundException;

class FreeTimeRepository
{
    public function get($id): FreeTime
    {
        if (!$FreeTime = FreeTime::findOne($id)){
            throw new NotFoundException('FreeTime is not found.');
        }

        return $FreeTime;
    }

    public function getLastId(): FreeTime
    {
        return FreeTime::find()->orderBy('id DESC')->one();
    }

    public function save(FreeTime $FreeTime):void
    {
        if (!$FreeTime->save()){
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(FreeTime $FreeTime):void
    {
        if (!$FreeTime->delete()){
            throw new \RuntimeException('Removing error.');
        }
    }

}