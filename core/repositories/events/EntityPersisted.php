<?php


namespace core\repositories\events;


class EntityPersisted
{
    public $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }
}