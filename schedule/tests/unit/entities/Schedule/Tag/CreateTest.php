<?php


namespace schedule\tests\unit\entities\Schedule\Tag;


use Codeception\Test\Unit;
use schedule\entities\Schedule\Tag;

class CreateTest extends Unit
{
    public function testSuccess()
    {
        $tag = Tag::create(
            $name = 'Name',
            $slug = 'slug'
        );
        $this->assertEquals($name, $tag->name);
        $this->assertEquals($slug, $tag->slug);

    }
}