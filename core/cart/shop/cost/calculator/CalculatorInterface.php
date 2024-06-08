<?php


namespace core\cart\shop\cost\calculator;


use core\cart\shop\CartItem;
use core\cart\shop\cost\Cost;

interface CalculatorInterface
{
    /**
     * @param CartItem[] $items
     * @return Cost
     */
    public function  getCost(array $items): Cost;
}