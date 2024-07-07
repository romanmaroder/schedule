<?php


namespace core\repositories\Schedule;


use core\entities\Schedule\Additional\Category;
use core\repositories\NotFoundException;

class AdditionalCategoryRepository
{
    public function get($id): Category
    {
        if (!$category = Category::findOne($id)) {
            throw new NotFoundException('Category is not found.');
        }
        return $category;
    }

    public function save(Category $category):void
    {
        if (!$category->save()){
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Category $category):void
    {
        if (!$category->delete()){
            throw new \RuntimeException('Removing error.');
        }
    }
}