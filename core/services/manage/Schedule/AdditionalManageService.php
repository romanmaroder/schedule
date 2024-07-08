<?php


namespace core\services\manage\Schedule;


use core\entities\Meta;
use core\entities\Schedule\Additional\Additional;
use core\forms\manage\Schedule\Additional\AdditionalCreateForm;
use core\forms\manage\Schedule\Additional\AdditionalEditForm;
use core\repositories\Schedule\AdditionalCategoryRepository;
use core\repositories\Schedule\AdditionalRepository;
use core\services\TransactionManager;

class AdditionalManageService
{
    private $services;
    private $categories;
    private $transaction;

    public function __construct(AdditionalRepository $services,
        AdditionalCategoryRepository $categories,
        TransactionManager $transaction)
    {
        $this->services = $services;
        $this->categories = $categories;
        $this->transaction = $transaction;
    }

    /**
     * @param AdditionalCreateForm $form
     * @return Additional
     */
    public function create(AdditionalCreateForm $form): Additional
    {
        $category = $this->categories->get($form->categories->main);
        $services = Additional::create(
            $category->id,
            $form->name,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords,
            )
        );

        $this->transaction->wrap(
            function () use ($services, $form) {

                $this->services->save($services);
            }
        );
        return $services;
    }

    public function edit($id, AdditionalEditForm $form): void
    {
        $service = $this->services->get($id);
        $category = $this->categories->get($form->categories->main);
        $service->edit(
            $form->name,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $service->changeMainCategory($category->id);

        $this->transaction->wrap(
            function () use ($service, $form) {
                $service->revokeCategories();
                $this->services->save($service);

                foreach ($form->categories->others as $otherId) {
                    $category = $this->categories->get($otherId);
                    $service->assignCategory($category->id);
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