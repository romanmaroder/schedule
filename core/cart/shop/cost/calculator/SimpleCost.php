<?php


namespace core\cart\shop\cost\calculator;


use core\cart\shop\CartItem;
use core\cart\shop\cost\Cost;

class SimpleCost implements CalculatorInterface
{

    public function getCost(array $items): Cost
    {
        {
            $cost = 0;
            foreach ($items as $item) {
                $cost += $item->getCost();
            }
            return new Cost($cost);
        }
    }
}