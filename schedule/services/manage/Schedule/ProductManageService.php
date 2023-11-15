<?php


namespace schedule\services\manage\Schedule;


use schedule\entities\Meta;
use schedule\entities\Schedule\Product\Product;
use schedule\entities\Schedule\Tag;
use schedule\forms\manage\Schedule\Product\ModificationForm;
use schedule\forms\manage\Schedule\Product\PhotosForm;
use schedule\forms\manage\Schedule\Product\PriceForm;
use schedule\forms\manage\Schedule\Product\ProductCreateForm;
use schedule\forms\manage\Schedule\Product\ProductEditForm;
use schedule\repositories\Schedule\BrandRepository;
use schedule\repositories\Schedule\CategoryRepository;
use schedule\repositories\Schedule\ProductRepository;
use schedule\repositories\Schedule\TagRepository;
use schedule\services\TransactionManager;

class ProductManageService
{
    private $products;
    private $brands;
    private $categories;
    private $tags;
    private $transaction;

    public function __construct(
        ProductRepository $products,
        BrandRepository $brands,
        CategoryRepository $categories,
        TagRepository $tags,
        TransactionManager $transaction
    ) {
        $this->products = $products;
        $this->brands = $brands;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->transaction = $transaction;
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
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords,
            )
        );
        $product->setPrice($form->price->new, $form->price->old, $form->price->intern, $form->price->employee);

        # Binding of additional categories to the product
        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->get($otherId);
            $product->assignCategory($category->id);
        }

        # Binding of values to the product
        foreach ($form->values as $value) {
            $product->setValue($value->id, $value->value);
        }
        # Linking photos to the product
        foreach ($form->photos->files as $file) {
            $product->addPhoto($file);
        }
        # Binding tags to the product
        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tags->get($tagId);
            $product->assignTag($tag->id);
        }

        $this->transaction->wrap(
            function () use ($product, $form) {
                foreach ($form->tags->newNames as $tagName) {
                    if (!$tag = $this->tags->findByName($tagName)) {
                        $tag = Tag::create($tagName, $tagName);
                        $this->tags->save($tag);
                    }
                    $product->assignTag($tag->id);
                }
                $this->products->save($product);
            }
        );

        return $product;
    }

    public function edit($id, ProductEditForm $form): void
    {
        $product = $this->products->get($id);
        $brand = $this->brands->get($form->brandId);
        $category = $this->categories->get($form->categories->main);
        $product->edit(
            $brand->id,
            $form->code,
            $form->name,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $product->changeMainCategory($category->id);

        $this->transaction->wrap(
            function () use ($product, $form) {

                $product->revokeCategories();

                $product->revokeTags();

                $this->products->save($product);

                foreach ($form->categories->others as $otherId) {
                    $category = $this->categories->get($otherId);
                    $product->assignCategory($category->id);
                }

                foreach ($form->values as $value) {
                    $product->setValue($value->id, $value->value);
                }

                foreach ($form->tags->existing as $tagId) {
                    $tag = $this->tags->get($tagId);
                    $product->assignTag($tag->id);
                }


                foreach ($form->tags->newNames as $tagName) {
                    if (!$tag = $this->tags->findByName($tagName)) {
                        $tag = Tag::create($tagName, $tagName);
                        $this->tags->save($tag);
                    }
                    $product->assignTag($tag->id);
                }
                $this->products->save($product);
            }
        );
    }

    public function changePrice($id, PriceForm $form): void
    {
        $product = $this->products->get($id);
        $product->setPrice($form->new, $form->old, $form->intern, $form->employee);
        $this->products->save($product);
    }

    public function activate($id): void
    {
        $product = $this->products->get($id);
        $product->activate();
        $this->products->save($product);
    }

    public function draft($id): void
    {
        $product = $this->products->get($id);
        $product->draft();
        $this->products->save($product);
    }

    public function addPhotos($id, PhotosForm $form): void
    {
        $product = $this->products->get($id);
        foreach ($form->files as $file) {
            $product->addPhoto($file);
        }
        $this->products->save($product);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $product = $this->products->get($id);
        $product->movePhotoUp($photoId);
        $this->products->save($product);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $product = $this->products->get($id);
        $product->movePhotoDown($photoId);
        $this->products->save($product);
    }

    public function removePhoto($id, $photoId): void
    {
        $product = $this->products->get($id);
        $product->removePhoto($photoId);
        $this->products->save($product);
    }

    public function addRelatedProduct($id, $otherId): void
    {
        $product = $this->products->get($id);
        $other = $this->products->get($otherId);
        $product->assignRelatedProduct($other->id);
        $this->products->save($product);
    }

    public function removeRelatedProduct($id, $otherId): void
    {
        $product = $this->products->get($id);
        $other = $this->products->get($otherId);
        $product->revokeRelatedProduct($other->id);
        $this->products->save($product);
    }

    # Modification

    public function addModification($id, ModificationForm $form): void
    {
        $product = $this->products->get($id);
        $product->addModification(
            $form->code,
            $form->name,
            $form->price
        );
        $this->products->save($product);
    }

    public function editModification($id, $modificationId, ModificationForm $form): void
    {
        $product = $this->products->get($id);
        $product->editModification(
            $modificationId,
            $form->code,
            $form->name,
            $form->price
        );
        $this->products->save($product);
    }

    public function removeModification($id, $modificationId): void
    {
        $product = $this->products->get($id);
        $product->removeModification($modificationId);
        $this->products->save($product);
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