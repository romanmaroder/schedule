<?php


namespace schedule\readModels\Schedule;


use schedule\entities\Schedule\Brand;

class BrandReadRepository
{
    public function find($id): ?Brand
    {
        return Brand::findOne($id);
    }
}