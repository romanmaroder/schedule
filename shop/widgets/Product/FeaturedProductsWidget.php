<?php


namespace shop\widgets\Product;


use core\readModels\Shop\ProductReadRepository;
use yii\base\Widget;

class FeaturedProductsWidget extends Widget
{
    public function __construct(public $limit,private readonly ProductReadRepository $repository, $config = [])
    {
        parent::__construct($config);
    }

    public function run()
    {
        return $this->render('featured', [
            'products' => $this->repository->getFeatured($this->limit)
        ]);
    }
}