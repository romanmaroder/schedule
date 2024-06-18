<?php


namespace core\services\Shop;


use core\cart\shop\Cart;
use core\cart\shop\CartItem;
use core\entities\Shop\Order\CustomerData;
use core\entities\Shop\Order\DeliveryData;
use core\entities\Shop\Order\Order;
use core\entities\Shop\Order\OrderItem;
use core\forms\Shop\Order\OrderForm;
use core\repositories\Shop\DeliveryMethodRepository;
use core\repositories\Shop\OrderRepository;
use core\repositories\Shop\ProductRepository;
use core\repositories\UserRepository;
use core\services\TransactionManager;
use yii\helpers\VarDumper;

class OrderService
{
    private $cart;
    private $orders;
    private $products;
    private $users;
    private $deliveryMethods;
    private $transaction;

    public function __construct(
        Cart $cart,
        OrderRepository $orders,
        ProductRepository $products,
        UserRepository $users,
        DeliveryMethodRepository $deliveryMethods,
        TransactionManager $transaction
    )
    {
        $this->cart = $cart;
        $this->orders = $orders;
        $this->products = $products;
        $this->users = $users;
        $this->deliveryMethods = $deliveryMethods;
        $this->transaction = $transaction;
    }

    public function checkout($userId, OrderForm $form): Order
    {
        $user = $this->users->get($userId);

        $products = [];

        $items = array_map(function (CartItem $item) use (&$products) {
            $product = $item->getProduct();
            $product->checkout($item->getModificationId(), $item->getQuantity());
            $products[] = $product;
            return OrderItem::create(
                $product,
                $item->getModificationId(),
                $item->getPrice(),
                $item->getQuantity()
            );
        }, $this->cart->getItems());

        $order = Order::create(
            $user->id,
            new CustomerData(
                $form->customer->phone,
                $form->customer->name
            ),
            $items,
            $this->cart->getCost()->getTotal(),
            $form->note
        );
        $order->setDeliveryInfo(
            $this->deliveryMethods->get($form->delivery->method),
            new DeliveryData(
                $form->delivery->index,
                $form->delivery->address
            )
        );

        $this->transaction->wrap(function () use ($order, $products) {
            $this->orders->save($order);
            foreach ($products as $product) {
                $this->products->save($product);
            }
            $this->cart->clear();
        });

        return $order;
    }
}