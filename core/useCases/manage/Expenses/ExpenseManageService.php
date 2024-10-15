<?php


namespace core\useCases\manage\Expenses;


use core\entities\Expenses\Expenses\Expenses;
use core\entities\Expenses\Expenses\Tag;
use core\forms\manage\Expenses\Expense\ExpenseCreateForm;
use core\forms\manage\Expenses\Expense\ExpenseEditForm;
use core\repositories\Expenses\CategoryRepository;
use core\repositories\Expenses\ExpenseRepository;
use core\repositories\Expenses\TagRepository;
use core\services\TransactionManager;

class ExpenseManageService
{
    private $services;
    private $categories;
    private $tags;
    private $transaction;

    public function __construct(ExpenseRepository $services,
        CategoryRepository $categories,
        TagRepository $tags,
        TransactionManager $transaction)
    {
        $this->services = $services;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->transaction = $transaction;
    }

    /**
     * @param ExpenseCreateForm $form
     * @return Expenses
     */
    public function create(ExpenseCreateForm $form): Expenses
    {
        $category = $this->categories->get($form->categories->main);
        $services = Expenses::create(
            $category->id,
            $form->name,
            $form->value,
            $form->status,
            $form->created_at,
        );

        # Binding of additional categories to the service
        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->get($otherId);
            $services->assignCategory($category->id);
        }

        # Binding tags to the service
        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tags->get($tagId);
            $services->assignTag($tag->id);
        }

        $this->transaction->wrap(
            function () use ($services, $form) {
                foreach ($form->tags->newNames as $tagName) {
                    if (!$tag = $this->tags->findByName($tagName)) {
                        $tag = Tag::create($tagName, $tagName);
                        $this->tags->save($tag);
                    }
                    $services->assignTag($tag->id);
                }
                $this->services->save($services);
            }
        );
        return $services;
    }

    public function edit($id, ExpenseEditForm $form): void
    {
        $service = $this->services->get($id);
        $category = $this->categories->get($form->categories->main);

        $service->edit(
            $form->name,
            $form->value,
            $form->status,
            $form->created_at,
        );
        $service->changeMainCategory($category->id);

        $this->transaction->wrap(
            function () use ($service, $form) {
                $service->revokeCategories();
                $service->revokeTags();
                $this->services->save($service);

                foreach ($form->categories->others as $otherId) {
                    $category = $this->categories->get($otherId);
                    $service->assignCategory($category->id);
                }


                foreach ($form->tags->existing as $tagId) {
                    $tag = $this->tags->get($tagId);
                    $service->assignTag($tag->id);
                }


                foreach ($form->tags->newNames as $tagName) {
                    if (!$tag = $this->tags->findByName($tagName)) {
                        $tag = Tag::create($tagName, $tagName);
                        $this->tags->save($tag);
                    }
                    $service->assignTag($tag->id);
                }
                $this->services->save($service);
            }
        );
    }


    public function activate($id): void
    {
        $service = $this->services->get($id);
        $service->activate();
        $this->services->save($service);
    }

    public function draft(int $id)
    {
        $service = $this->services->get($id);
        $service->draft();
        $this->services->save($service);
    }

    /**
     * @param $id
     */
    public function remove($id): void
    {
        $services = $this->services->get($id);
        $this->services->remove($services);
    }
}