<?php


namespace schedule\services\manage\Schedule;


use schedule\entities\Meta;
use schedule\entities\Schedule\Product\Product;
use schedule\forms\manage\Schedule\Product\ProductCreateForm;
use schedule\repositories\Schedule\BrandRepository;
use schedule\repositories\Schedule\CategoryRepository;
use schedule\repositories\Schedule\ProductRepository;

class ProductManageService
{
    private $products;
    private $brands;
    private $categories;

    public function __construct(ProductRepository $products, BrandRepository $brands, CategoryRepository $categories)
    {
        $this->products = $products;
        $this->brands = $brands;
        $this->categories = $categories;
    }

    /**
     * @param ProductCreateForm $form
     * @return Product
     */
    public function create(ProductCreateForm $form): Product
    {
        $brand = $this->brands->get($form->brandId);
        $category = $this->categories->get($form->categories->main);
        $product = Product::create(
            $brand->id,
            $category->id,
            $form->code,
            $form->name,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords,
            )
        );
        $product->setPrice($form->price->new, $form->price->old, $form->price->intern, $form->price->employee);

        # Binding of additional categories to the product
        foreach ($form->categories->other as $otherId) {
            $category = $this->categories->get($otherId);
            $product->assignCategory($category->id);
        }

        # Binding of values to the product
        foreach ($form->values as $value) {
            $product->setValue($value->id, $value->value);
        }

        $this->products->save($product);
        return $product;
    }

    /**
     * @param $id
     */
    public function remove($id): void
    {
        $product = $this->products->get($id);
        $this->products->remove($product);
    }
}