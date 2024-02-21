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
        return array_sum(array_map(function ($service){
            return $service->price_new * $this->getEmployeePrice();
        },$this->events->services));

    }

    public function getPriceList():array
    {
        return  array_map(function ($service){
            return $service->price_new  * $this->getEmployeePrice();
        },$this->events->services);

    }

    public function getServiceList():array
    {
        return  array_map(function ($service){
            return $service->name. PHP_EOL;
        },$this->events->services);
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
