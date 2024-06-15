<?php


namespace core\services\cabinet;


use core\repositories\Shop\ProductRepository;
use core\repositories\UserRepository;

class WishlistService
{
    private $users;
    private $products;

    public function __construct(UserRepository $users, ProductRepository $products)
    {
        $this->users = $users;
        $this->products = $products;
    }

    public function add($userId, $productId): void
    {
        $user = $this->users->get($userId);
        $product = $this->products->get($productId);
        $user->addToWishList($product->id);
        $this->users->save($user);
    }

    public function quantity($userId)
    {
        $user = $this->users->get($userId);
        $user->wishListQuantity();
    }

    public function remove($userId, $productId): void
    {
        $user = $this->users->get($userId);
        $product = $this->products->get($productId);
        $user->removeFromWishList($product->id);
        $this->users->save($user);
    }
}