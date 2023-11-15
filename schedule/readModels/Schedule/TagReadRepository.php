<?php


namespace schedule\readModels\Schedule;


use schedule\entities\Schedule\Tag;

class TagReadRepository
{
    public function find($id): ?Tag
    {
        return Tag::findOne($id);
    }
}