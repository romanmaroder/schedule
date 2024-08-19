<?php


namespace core\useCases\Shop;


use core\cart\shop\Cart;
use core\cart\shop\CartItem;
use core\repositories\Shop\ProductRepository;

class CartService
{
    private $cart;
    private $products;

    public function __construct(Cart $cart, ProductRepository $products)
    {
        $this->cart = $cart;
        $this->products = $products;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function add($productId, $modificationId, $quantity): void
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
    }
}