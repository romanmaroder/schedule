<?php


namespace core\services\manage\Schedule;


use core\entities\Meta;
use core\entities\Schedule\Service\Service;
use core\entities\Schedule\Tag;
use core\forms\manage\Schedule\Service\PriceForm;
use core\forms\manage\Schedule\Service\ServiceCreateForm;
use core\forms\manage\Schedule\Service\ServiceEditForm;
use core\repositories\Schedule\CategoryRepository;
use core\repositories\Schedule\ServiceRepository;
use core\repositories\Schedule\TagRepository;
use core\services\TransactionManager;

class ServiceManageService
{
    private $services;
    private $categories;
    private $tags;
    private $transaction;

    public function __construct(ServiceRepository $services,
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
     * @param ServiceCreateForm $form
     * @return Service
     */
    public function create(ServiceCreateForm $form): Service
    {
        $category = $this->categories->get($form->categories->main);
        $services = Service::create(
            $category->id,
            $form->name,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords,
            )
        );
        $services->setPrice($form->price->new, $form->price->old);

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

    public function edit($id, ServiceEditForm $form): void
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

    public function changePrice($id, PriceForm $form): void
    {
        $service = $this->services->get($id);
        $service->setPrice($form->new, $form->old);
        $this->services->save($service);
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