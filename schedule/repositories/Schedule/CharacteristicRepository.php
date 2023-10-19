<?php


namespace schedule\repositories\Schedule;


use schedule\entities\Schedule\Characteristic;
use schedule\repositories\NotFoundException;

class CharacteristicRepository
{
    /**
     * @param $id
     * @return Characteristic
     */
    public function get($id): Characteristic
    {
        if (!$characteristic = Characteristic::findOne($id)) {
            throw new NotFoundException('Characteristic not found.');
        }
        return $characteristic;
    }

    public function save(Characteristic $characteristic):void
    {
        if (!$characteristic->save()){
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Characteristic $characteristic):void
    {
        if (!$characteristic->delete()){
            throw new \RuntimeException('Removing error.');
        }
    }
}