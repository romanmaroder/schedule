<?php


namespace shop\widgets\Cart\Shop;


use core\cart\shop\Cart;
use yii\base\Widget;

class CartWidget extends Widget
{
    public function __construct(private readonly Cart $cart, $config = [])
    {
        parent::__construct($config);
    }

    public function run(): string
    {
        return $this->render('quantity', [
            'cart' => $this->cart,
        ]);
    }
}