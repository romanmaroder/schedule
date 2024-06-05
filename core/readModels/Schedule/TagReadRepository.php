<?php


namespace core\readModels\Schedule;


use core\entities\Schedule\Tag;

class TagReadRepository
{
    public function find($id): ?Tag
    {
        return Tag::findOne($id);
    }
}