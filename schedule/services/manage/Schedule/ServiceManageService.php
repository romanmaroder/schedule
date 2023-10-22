<?php


namespace schedule\services\manage\Schedule;


use schedule\entities\Meta;
use schedule\entities\Schedule\Service\Service;
use schedule\forms\manage\Schedule\Service\CategoriesForm;
use schedule\forms\manage\Schedule\Service\ServiceCreateForm;
use schedule\repositories\Schedule\CategoryRepository;
use schedule\repositories\Schedule\ServiceRepository;

class ServiceManageService
{
    private $services;
    private $categories;

    public function __construct(ServiceRepository $services, CategoryRepository $categories)
    {
        $this->services = $services;
        $this->categories = $categories;
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
        foreach ($form->categories->other as $otherId) {
            $category = $this->categories->get($otherId);
            $services->assignCategory($category->id);
        }

        $this->services->save($services);
        return $services;
    }

    public function changeCategories($id, CategoriesForm $form): void
    {

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