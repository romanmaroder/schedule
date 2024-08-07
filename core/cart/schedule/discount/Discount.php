<?php


namespace core\cart\schedule\discount;

/**
 * Class Discount
 * @package core\cart\discount
 */
class Discount
{
    /**
     * The client pays the full cost of the service according to the master’s price list.
     * Salary and income are calculated from the rates and price lists specified by the master.
     * If the rate and price list == 100%, the master’s salary is not calculated.
     */
    public const NO_DISCOUNT = 0;

    /**
     * The master indicates the cost of the discount.
     * The discount is deducted from the master’s salary.
     * The client pays the cost of the service at a discount.
     */
    public const MASTER_DISCOUNT = 1;

    /**
     * The discount is divided in half between the master and the salon.
     * It is deducted from the master’s salary and the salon’s income.
     * The client pays the cost of the service at a discount.
     */
    public const STUDIO_DISCOUNT = 2;

    /**
     * The discount is deducted from the income.
     * The client pays the cost of the service at a discount.
     */
    public const STUDIO_DISCOUNT_WITH_MASTER_WORK = 3;

}