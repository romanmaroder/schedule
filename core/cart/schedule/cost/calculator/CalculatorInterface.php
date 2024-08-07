<?php


namespace core\cart\schedule\cost\calculator;




use core\cart\schedule\CartItem;
use core\cart\schedule\cost\Cost;

interface CalculatorInterface
{

    /**
     * @param CartItem[] $items
     * @return Cost
     */
    public function  getCost(array $items): Cost;
}
