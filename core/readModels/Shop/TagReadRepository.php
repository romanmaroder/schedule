<?php


namespace core\readModels\Shop;


use core\entities\Shop\Product\Tag;

class TagReadRepository
{
    public function find($id): ?Tag
    {
        return Tag::findOne($id);
    }
}