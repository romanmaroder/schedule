<?php


namespace schedule\cart\cost\calculator;


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