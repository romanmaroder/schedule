<?php


namespace core\jobs\Shop\Product;


use core\entities\Shop\Product\Product;
use core\jobs\Job;

class ProductAvailabilityNotification extends Job
{
    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}