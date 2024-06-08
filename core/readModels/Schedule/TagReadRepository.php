<?php


namespace core\readModels\Schedule;


use core\entities\Schedule\Service\Tag;

class TagReadRepository
{
    public function find($id): ?Tag
    {
        return Tag::findOne($id);
    }
}