<?php


namespace core\entities\Shop\Order;


class Status
{
    public function __construct(public $value, public $created_at){}
}