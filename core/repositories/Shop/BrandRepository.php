<?php


namespace core\repositories\Shop;


use core\entities\CommonUses\Brand;
use core\repositories\NotFoundException;

class BrandRepository
{

    /**
     * @param $id
     * @return Brand
     */
    public function get($id): Brand
    {
        if (!$brand = Brand::findOne($id)){
            throw new NotFoundException('Brand is not found.');
        }
        return $brand;
    }

    public function save(Brand $brand):void
    {
        if (!$brand->save()){
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Brand $brand): void
    {
        if (!$brand->delete()){
            throw new \RuntimeException('Removing error.');
        }
    }

}