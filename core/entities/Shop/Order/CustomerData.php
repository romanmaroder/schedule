<?php


namespace core\entities\Shop\Order;


use core\helpers\tHelper;

class CustomerData
{
    public function __construct(public $phone, public $name){}

    public function attributeLabels(): array
    {
        return [
            'name' => tHelper::translate('shop/customer','name'),
            'phone' => tHelper::translate('shop/customer','phone'),
        ];
    }
}