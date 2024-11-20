<?php


namespace core\tests\unit\entities\Schedule\Brand;


use Codeception\Test\Unit;
use core\entities\CommonUses\Brand;
use core\entities\Meta;

class CreateTest extends Unit
{
    public function testSuccess()
    {
        $brand = Brand::create(
            $name = 'Name',
            $slug = 'slug',
            $meta = new Meta('title', 'Description', 'Keywords'),
        );

        $this->assertEquals($name, $brand->name);
        $this->assertEquals($slug, $brand->slug);
        $this->assertEquals($meta, $brand->meta);
    }
}