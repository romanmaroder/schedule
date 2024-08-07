<?php


namespace core\cart\schedule\cost\calculator;


use core\cart\schedule\cost\Cost;

class SimpleCost implements CalculatorInterface
{

    public function getCost(array $items): Cost
    {
        $cost = 0;
        foreach ($items as $item) {
            $cost += $item->getCost();
        }
        return new Cost($cost);
    }
}