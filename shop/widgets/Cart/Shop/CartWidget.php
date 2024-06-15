<?php


namespace shop\widgets\Cart\Shop;


use core\cart\shop\Cart;
use yii\base\Widget;

class CartWidget extends Widget
{
    private $cart;

    public function __construct(Cart $cart, $config = [])
    {
        parent::__construct($config);
        $this->cart = $cart;
    }

    public function run(): string
    {
        return $this->render('quantity', [
            'cart' => $this->cart,
        ]);
    }
}