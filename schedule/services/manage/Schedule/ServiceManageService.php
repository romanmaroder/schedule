<?php


namespace schedule\services\manage\Schedule;


use schedule\entities\Meta;
use schedule\entities\Schedule\Service\Service;
use schedule\entities\Schedule\Tag;
use schedule\forms\manage\Schedule\Service\CategoriesForm;
use schedule\forms\manage\Schedule\Service\ServiceCreateForm;
use schedule\repositories\Schedule\CategoryRepository;
use schedule\repositories\Schedule\ServiceRepository;
use schedule\repositories\Schedule\TagRepository;
use schedule\services\TransactionManager;

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
        $services->setPrice($form->price->new, $form->price->old, $form->price->intern, $form->price->employee);

        # Binding of additional categories to the product
        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->get($otherId);
            $services->assignCategory($category->id);
        }

        # Binding tags to the product
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
                $this->products->save($services);
            }
        );
        return $services;
    }

    public function changeCategories($id, CategoriesForm $form): void
    {
        $service = $this->services->get($id);
        $category = $this->categories->get($form->main);
        $service->changeMainCategory($category->id);
        $service->revokeCategories();
        foreach ($form->others as $otherId) {
            $category = $this->categories->get($otherId);
            $service->assignCategory($category->id);
        }
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