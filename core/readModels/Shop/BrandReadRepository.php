<?php


namespace core\readModels\Shop;


use core\entities\CommonUses\Brand;

class BrandReadRepository
{
    public function find($id): ?Brand
    {
        return Brand::findOne($id);
    }
}