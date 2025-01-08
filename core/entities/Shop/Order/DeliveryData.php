<?php


namespace core\entities\Shop\Order;


class DeliveryData
{
    public function __construct(public $index, public $address){}
}