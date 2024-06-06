<?php


namespace core\repositories\Schedule;


use core\entities\CommonUses\Brand;
use core\repositories\NotFoundException;

class BrandRepository
{

    /**
     * @param $id
     * @return \core\entities\CommonUses\Brand
     */
    public function get($id): \core\entities\CommonUses\Brand
    {
        if (!$brand = Brand::findOne($id)){
            throw new NotFoundException('Brand is not found.');
        }
        return $brand;
    }

    public function save(\core\entities\CommonUses\Brand $brand):void
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