<?php


namespace schedule\services\manage\Schedule;


use schedule\entities\Meta;
use schedule\entities\Schedule\Brand;
use schedule\forms\manage\Schedule\BrandForm;
use schedule\repositories\Schedule\BrandRepository;

class BrandManageService
{
private $brands;

    /**
     * BrandManageService constructor.
     * @param $brands
     */
    public function __construct(BrandRepository $brands)
    {
        $this->brands = $brands;
    }

    /**
     * @param BrandForm $form
     * @return Brand
     */
    public function create(BrandForm $form): Brand
    {
        $brand = Brand::create(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords,
            ),
        );
        $this->brands->save($brand);
        return $brand;
    }

    /**
     * @param $id
     * @param BrandForm $form
     */
    public function edit($id, BrandForm $form): void
    {
        $brand = $this->brands->get($id);
        $brand->edit(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brands->save($brand);
    }

    /**
     * @param $id
     */
    public function remove($id):void
    {
        $brand= $this->brands->get($id);
        $this->brands->remove($brand);
    }
}