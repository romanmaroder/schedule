<?php


namespace core\entities\Shop\Product\events;


use core\entities\Shop\Product\Product;

class ProductAppearedInStock
{

    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}