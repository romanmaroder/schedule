<?php


namespace core\repositories\Shop;


use core\dispatchers\EventDispatcher;
use core\entities\Shop\Product\Category;
use core\repositories\events\EntityPersisted;
use core\repositories\events\EntityRemoved;
use core\repositories\NotFoundException;

class CategoryRepository
{

    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

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
        $this->dispatcher->dispatch(new EntityPersisted($category));
    }

    public function remove(Category $category):void
    {
        if (!$category->delete()){
            throw new \RuntimeException('Removing error.');
        }
        $this->dispatcher->dispatch(new EntityRemoved($category));
    }
}