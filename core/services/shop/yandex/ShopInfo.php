<?php


namespace core\services\shop\yandex;


class ShopInfo
{
    public $name;
    public $company;
    public $url;

    public function __construct($name, $company, $url)
    {
        $this->name = $name;
        $this->company = $company;
        $this->url = $url;
    }
}