<?php


namespace schedule\services\manage\Schedule;


use schedule\entities\Meta;
use schedule\entities\Schedule\Brand;
use schedule\forms\manage\Schedule\BrandForm;
use schedule\repositories\Schedule\BrandRepository;
use schedule\repositories\Schedule\ProductRepository;

class BrandManageService
{
    private $brands;
    private $products;

    /**
     * BrandManageService constructor.
     * @param BrandRepository $brands
     * @param ProductRepository $products
     */
    public function __construct(BrandRepository $brands,ProductRepository $products)
    {
        $this->brands = $brands;
        $this->products=$products;
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
        if ($this->products->existsByBrand($brand->id)) {
            throw new \DomainException('Unable to remove brand with products.');
        }
        $this->brands->remove($brand);
    }
}