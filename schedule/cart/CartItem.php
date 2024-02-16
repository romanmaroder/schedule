<?php

namespace schedule\cart;

use schedule\entities\Schedule\Event\Event;

class CartItem
{
    private $events;


    public function __construct(Event $events)
    {
        $this->events = $events;
    }


    public function getEvents(): Event
    {
        return $this->events;
    }

    public function getTotalPrice(): int
    {
        $price = null;
        foreach ($this->events->services as $item) {
            $price += $item->price_new * $this->getEmployeePrice();
        }
        return $price;
    }

    public function getPriceList():string
    {
        $prices = '';
        foreach ($this->events->services as $item) {
            $prices .= $item->price_new * $this->getEmployeePrice() . '</br>';
        }
        return $prices;
    }

    public function getServiceList(): string
    {
        $service = '';
        foreach ($this->events->services as $item) {
            $service .= $item->name . '</br>';
        }
        return $service;
    }

    public function getDiscount()
    {
        return $this->events->client->getDiscount();
    }

    public function getCost(): int|float
    {
        return $this->getTotalPrice() * (1 - $this->getDiscount() / 100);
    }

    public function getSalary(): float|int
    {
        return $this->getCost() * $this->getEmployeeRate();
    }

    private function getEmployeeRate()
    {
        return $this->events->employee->rate->rate;
    }

    private function getEmployeePrice()
    {
        return $this->events->employee->price->rate;
    }


}
