<?php

namespace core\cart\schedule;

use core\cart\discount\Discount;
use core\entities\Schedule\Event\ServiceAssignment;

/**
 * If the rate and price are 100% (1), the foreman's wages are not included.
 */
class CartItemOrigin
{
    private $item;


    public function __construct(ServiceAssignment $item)
    {
        $this->item = $item;
    }

    public function getEvents(): ServiceAssignment
    {
        return $this->item;
    }

    public function getId(): int
    {
        return $this->item->event_id;
    }

    public function getColor(): string
    {
        return $this->item->events->getDefaultColor();
    }

    public function getDate(): string
    {
        return $this->item->events->start;
    }

    public function getMasterName(): string
    {
        return $this->item->events->getFullName();
    }

    public function getClientName(): string
    {
        return $this->item->events->client->username;
    }

    public function getStatus(): int
    {
        return $this->item->events->status;
    }

    public function getCash(): float|int
    {
        if ($this->item->events->isCashPayment()) {
            return $this->getDiscountedPrice();
        }
        return false;
    }

    public function getCard(): float|int
    {
        if ($this->item->events->isCardPayment()) {
            return $this->getDiscountedPrice();
        }
        return false;
    }

    /**
     * Discount
     * @return int|null
     */
    public function getDiscount(): int|null
    {
        return $this->item->events->getDiscount();
    }

    /**
     * Original price
     * @return int|null
     */
    public function getOriginalPrice(): int|null
    {
        return $this->item->cost;
    }

    /**
     * The price of the service takes into account the price of the master
     * @return float|int
     */
    public function getMasterPrice(): float|int
    {
        #Rounding up
        //return round($this->getOriginalPrice() * $this->getEmployeePrice(),-2,PHP_ROUND_HALF_EVEN);
       return $this->getOriginalPrice() * $this->getEmployeePrice();
    }

    /**
     * Discounted service price
     * @return float|int
     */
    public function getDiscountedPrice(): float|int
    {
        return ceil(
            $this->getMasterPrice() - ($this->getMasterPrice() * $this->getEmployeeRate() *
                ($this->getDiscount() / 100))
        );
    }
    /**
     * Discount cost
     * @return float|int
     */
    public function getDiscountCost(): float|int
    {
        return $this->getMasterPrice() - $this->getDiscountedPrice();
    }

    public function getDiscountFrom(): float|int
    {
        return $this->item->events->discount_from;
    }

    /**
     *
     * @return float|int
     */
    public function getCost(): float|int
    {
        switch ($this->getDiscountFrom()) {
            case Discount::NO_DISCOUNT:
                $cost = $this->getWithOutDiscount();
                break;
            case Discount::MASTER_DISCOUNT:
                $cost = $this->getDiscountFromEmployee();
                break;
            case Discount::STUDIO_DISCOUNT:
                $cost = $this->getDiscountFromTheStudio();
                break;
            case Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK :
                $cost = $this->getCostDiscountFromTheStudioWithMaster();
                break;
            default:
                $cost = $this->getWithOutDiscount();
        }

        /* $cost = match ($this->getDiscountFrom()) {
            Discount::NO_DISCOUNT => $this->getWithOutDiscount(),
            Discount::MASTER_DISCOUNT => $this->getDiscountFromEmployee(),
            Discount::STUDIO_DISCOUNT => $this->getDiscountFromTheStudio(),
            Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK => $this->getCostDiscountFromTheStudioWithMaster(),
            default => $this->getWithOutDiscount(),
        };*/

        return $cost;
    }

    /**
     * @return float|int
     */
    public function getProfit(): float|int
    {
        switch ($this->getDiscountFrom()) {
            case Discount::NO_DISCOUNT:
                $profit = $this->getProfitWithOutDiscount();
                break;
            case Discount::STUDIO_DISCOUNT:
                $profit =  $this->getProfitWithOutDiscountAndStudioDiscount();
                break;
            case Discount::MASTER_DISCOUNT:
                $profit = $this->getProfitMasterDiscount();
                break;
            case Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK:
                $profit = $this->getProfitDiscountFromTheStudioWithMaster();
                break;
            default:
                $profit = $this->getProfitWithOutDiscount();
        }
        return $profit;
        /* $profit = match ($this->getDiscountFrom()) {
            Discount::NO_DISCOUNT, Discount::STUDIO_DISCOUNT => $this->getProfitWithOutDiscountAndStudioDiscount(),
            Discount::MASTER_DISCOUNT => $this->getProfitMasterDiscount(),
            Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK => $this->getProfitDiscountFromTheStudioWithMaster(),
            default => $this->getWithOutDiscount(),
        };*/
    }


    public function getServiceList(): string
    {
        return $this->item->services->name;
    }

    public function getCategory(): string
    {
        return $this->item->services->category->name;
    }

    public function getSalary(): float|int
    {
        return $this->getCost();
    }

    public function getTotalProfit(): float|int
    {
        return $this->getProfit();
    }

    public function getEmployeeRate(): float|int
    {
        return  $this->item->events->getRate();
    }

    public function getEmployeePrice(): float|int
    {
        return $this->item->events->getPrice();
    }

    /**
     * Discount from the master
     * @return float|int
     */
    private function getDiscountFromEmployee(): float|int
    {
        return $this->getMasterPrice() * $this->getEmployeeRate() -
            ($this->getMasterPrice() * $this->getEmployeeRate() * ($this->getDiscount() / 100));
    }

    /**
     * Studio discount
     * @return float|int
     */
    private function getDiscountFromTheStudio(): float|int
    {
        return $this->getDiscountedPrice() * $this->getEmployeeRate();
        //return $this->getDiscount() * $this->getEmployeeRate();
    }

    /**
     * No discounts
     * @return float|int
     */
    private function getWithOutDiscount(): float|int
    {
        if ($this->getEmployeeRate() == 1 && $this->getEmployeePrice() == 1) {
            return 0;
        }
        return $this->getMasterPrice() * $this->getEmployeeRate();
    }

    /**
     * No discounts
     * @return float|int
     */
    private function getProfitWithOutDiscount(): float|int
    {
        if ($this->getEmployeeRate() == 1 && $this->getEmployeePrice() == 1) {
        return $this->getMasterPrice() * $this->getEmployeeRate();
        }
            return $this->getDiscountedPrice() - $this->getSalary();
    }


    /**
     * Studio discount - employee work
     * @return float|int
     */
    private function getCostDiscountFromTheStudioWithMaster(): float|int
    {
        return $this->getMasterPrice() * $this->getEmployeeRate();
    }

    private function getProfitDiscountFromTheStudioWithMaster(): float|int
    {
        return $this->getMasterPrice() * $this->getEmployeeRate() - ($this->getMasterPrice() *
                $this->getEmployeeRate() * $this->getDiscount() / 100);
    }

    private function getProfitMasterDiscount(): float|int
    {
        return $this->getDiscountedPrice() - $this->getSalary();
    }

    private function getProfitWithOutDiscountAndStudioDiscount(): float|int
    {
        return $this->getDiscountedPrice() - $this->getSalary();
    }

}
