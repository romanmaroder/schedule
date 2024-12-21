<?php


namespace core\useCases\Schedule;


use core\cart\schedule\CartWithParams;

class CartWithParamsService
{
    private $cart;

    public function __construct(CartWithParams $cart)
    {
        $this->cart = $cart;
    }

    public function getCart(): CartWithParams
    {
        return $this->cart;
    }

    public function setParams(array $params): array
    {
        return $this->cart->setParams($params);
    }

    public function getTotalWithSubtractions($expense)
    {
        return $this->cart->getTotalWithSubtractions($expense);
    }

    public function getCash(): float|int
    {
        return $this->cart->getCash();
    }

    public function getCard(): float|int
    {
        return $this->cart->getCard();
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