<?php


namespace core\entities\Shop\Order;


use core\helpers\tHelper;

class CustomerData
{
    public $phone;
    public $name;

    public function __construct($phone, $name)
    {
        $this->phone = $phone;
        $this->name = $name;
    }

    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('shop/customer','name'),
            'phone' => tHelper::translate('shop/customer','phone'),
        ];
    }
}