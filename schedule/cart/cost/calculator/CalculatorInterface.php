<?php


namespace schedule\cart\cost\calculator;


interface CalculatorInterface
{

    /**
     * @param CartItem[] $items
     * @return Cost
     */
    public function  getCost(array $items): Cost;
}
