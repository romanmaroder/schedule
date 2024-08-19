<?php


namespace core\useCases\manage\Schedule;


use core\entities\Meta;
use core\entities\Schedule\Service\Category;
use core\forms\manage\Schedule\CategoryForm;
use core\repositories\Schedule\CategoryRepository;
use core\repositories\Schedule\ServiceRepository;

class CategoryManageService
{
    private $categories;
    private $services;

    public function __construct(CategoryRepository $categories, ServiceRepository $services)
    {
        $this->categories = $categories;
        $this->services = $services;
    }

    /**
     * @param CategoryForm $form
     * @return \core\entities\Schedule\Service\Category
     */
    public function create(CategoryForm $form):Category
    {
        $parent = $this->categories->get($form->parentId);
        $category = Category::create(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $category->appendTo($parent);
        $this->categories->save($category);
        return $category;
    }

    /**
     * @param $id
     * @param CategoryForm $form
     */
    public function edit($id, CategoryForm $form):void
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        $category->edit(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        if ($form->parentId !== $category->parent->id){
            $parent = $this->categories->get($form->parentId);
            $category->appendTo($parent);
        }
        $this->categories->save($category);
    }

    public function moveUp($id):void
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        if ($prev = $category->prev){
            $category->insertBefore($prev);
        }
        $this->categories->save($category);
    }

    public function moveDown($id):void
    {
        $category=$this->categories->get($id);
        $this->assertIsNotRoot($category);
        if ($next=$category->next){
            $category->insertAfter($next);
        }
        $this->categories->save($category);
    }

    public function remove($id):void
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        if ($this->services->existsByMainCategory($category->id)) {
            throw new \DomainException('Unable to remove category with services.');
        }
        $this->categories->remove($category);
    }

    /**
     * @param Category $category
     */
    private function assertIsNotRoot(Category $category): void
    {
        if ($category->isRoot()){
            throw new \DomainException('Unable to manage the root category.');
        }
    }
}