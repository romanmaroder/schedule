<?php


namespace schedule\tests\unit\entities\Schedule\Brand;


use Codeception\Test\Unit;
use schedule\entities\Meta;
use schedule\entities\Schedule\Brand;

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