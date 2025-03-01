<?php


namespace core\tests\unit\entities\Schedule\Characteristic;


use Codeception\Test\Unit;
use core\entities\CommonUses\Characteristic;

class CreateTest extends Unit
{
    public function testSuccess()
    {
        $characteristic = Characteristic::create(
            $name = 'Name',
            $type = Characteristic::TYPE_INTEGER,
            $required = true,
            $default = 0,
            $variants = [4, 12],
            $sort = 15
        );
        $this->assertEquals($name, $characteristic->name);
        $this->assertEquals($type, $characteristic->type);
        $this->assertEquals($required, $characteristic->required);
        $this->assertEquals($default, $characteristic->default);
        $this->assertEquals($variants, $characteristic->variants);
        $this->assertEquals($sort, $characteristic->sort);
        $this->assertTrue($characteristic->isSelect());

    }
}