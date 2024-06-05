<?php


namespace core\tests\unit\entities\core\Brand;


use Codeception\Test\Unit;
use core\entities\Meta;
use core\entities\core\Brand;

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