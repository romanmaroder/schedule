<?php

namespace schedule\cart;

use schedule\entities\Schedule\Event\Event;

class CartItem
{
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }


    public function getEventId()
    {
        return $this->event->id;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getPrice(): int
    {
        $price = null;
        foreach ($this->event->services as $item) {
            $price += ($item->price_new * $this->getPriceEmployee() );
        }
        return $price;
    }

    public function getPrices()
    {
        $prices = '';
        foreach ($this->event->services as $item) {
            $prices .= ($item->price_new * $this->getPriceEmployee() ). '</br>';
        }
        return $prices;
    }

    public function getDiscount()
    {
        return $this->event->client->getDiscount();
    }

    public function getServices()
    {
        $service = '';
        foreach ($this->event->services as $item) {
            $service .= $item->name . '</br>';
        }
        return $service;
    }

    public function getRate()
    {
        return $this->event->employee->rate->rate;
    }

    public function getPriceEmployee()
    {
        return $this->event->employee->price->rate;
    }

    public function getCost(): int|float
    {
        return $this->getPrice() * (1 - $this->getDiscount() / 100);
    }

    public function getSalary()
    {
        return $this->getCost() * $this->getRate();
    }


}
