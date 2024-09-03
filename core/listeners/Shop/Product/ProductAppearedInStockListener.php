<?php


namespace core\listeners\Shop\Product;


use core\entities\Shop\Product\events\ProductAppearedInStock;
use core\jobs\Shop\Product\ProductAvailabilityNotificationHandler;
use core\repositories\UserRepository;
use yii\queue\Queue;

class ProductAppearedInStockListener
{

    private $queue;

    public function __construct(UserRepository $users, Queue $queue)
    {
        $this->queue = $queue;
    }

    public function handle(ProductAppearedInStock $event): void
    {
        if ($event->product->isActive()) {
            $this->queue->push(new ProductAvailabilityNotificationHandler($event->product));
        }
    }
}