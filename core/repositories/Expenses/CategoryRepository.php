<?php


namespace core\repositories\Expenses;


use core\entities\Expenses\Category;
use core\repositories\NotFoundException;

class CategoryRepository
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