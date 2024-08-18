<?php


namespace core\readModels\Shop;


use core\entities\Shop\DeliveryMethod;

class DeliveryMethodReadRepository
{
    public function getAll(): array
    {
        return DeliveryMethod::find()->orderBy('sort')->all();
    }
}