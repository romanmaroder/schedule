<?php


namespace schedule\services\schedule;


use schedule\cart\Cart;

class CartService
{
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    /*public function add($productId, $modificationId, $quantity): void
    {
        $product = $this->products->get($productId);
        $modId = $modificationId ? $product->getModification($modificationId)->id : null;
        $this->cart->add(new CartItem($product, $modId, $quantity));
    }

    public function set($id, $quantity): void
    {
        $this->cart->set($id, $quantity);
    }

    public function remove($id): void
    {
        $this->cart->remove($id);
    }

    public function clear(): void
    {
        $this->cart->clear();
    }*/
}