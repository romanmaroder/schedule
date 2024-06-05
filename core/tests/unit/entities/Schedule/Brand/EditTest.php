<?php


namespace core\tests\unit\entities\core\Brand;


use Codeception\Test\Unit;
use core\entities\Meta;
use core\entities\core\Brand;

class EditTest extends Unit
{
    public function testSuccess()
    {
        $brand = new Brand([
            'name' => 'Old Name',
            'slug' => 'old-slug'
        ]);
        $brand->edit(
            $name = 'New Name',
            $slug = 'new-slug',
            $meta = new Meta('Title', 'Description', 'Keywords')
        );

        $this->assertEquals($name, $brand->name);
        $this->assertEquals($slug, $brand->slug);
        $this->assertEquals($meta, $brand->meta);

    }
}