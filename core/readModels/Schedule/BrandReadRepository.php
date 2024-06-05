<?php


namespace core\readModels\Schedule;


use core\entities\Schedule\Brand;

class BrandReadRepository
{
    public function find($id): ?Brand
    {
        return Brand::findOne($id);
    }
}