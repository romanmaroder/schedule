<?php

namespace core\cart;

use core\entities\Schedule\Event\ServiceAssignment;

/**
 * If the rate and price are 100% (1), the foreman's wages are not included.
 */
class CartItem
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
            case 0:
                $cost = $this->getWithOutDiscount();
                break;
            case 1:
                $cost = $this->getDiscountFromEmployee();
                break;
            case 2:
                $cost = $this->getDiscountFromTheStudio();
                break;
            case 3 :
                $cost = $this->getCostDiscountFromTheStudioWithMaster();
                break;
            default:
                $cost = $this->getWithOutDiscount();
        }

        /* $cost = match ($this->getDiscountFrom()) {
            0 => $this->getWithOutDiscount(),
            1 => $this->getDiscountFromEmployee(),
            2 => $this->getDiscountFromTheStudio(),
            3 => $this->getCostDiscountFromTheStudioWithMaster(),
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
            case 0:
            case 2:
                $profit = $this->getProfitWithOutDiscountAndStudioDiscount();
                break;
            case 1:
                $profit = $this->getProfitMasterDiscount();
                break;
            case 3:
                $profit = $this->getProfitDiscountFromTheStudioWithMaster();
                break;
            default:
                $profit = $this->getWithOutDiscount();
        }
        return $profit;
        /* $profit = match ($this->getDiscountFrom()) {
            0, 2 => $this->getProfitWithOutDiscountAndStudioDiscount(),
            1 => $this->getProfitMasterDiscount(),
            3 => $this->getProfitDiscountFromTheStudioWithMaster(),
            default => $this->getWithOutDiscount(),
        }*/
    }


    public function getServiceList(): string
    {
        return $this->item->services->name;
    }

    public function getCategory(): string
    {
        return $this->item->services->category->parent->parent->name;
    }

    public function getSalary(): float|int
    {
        return $this->getCost();
    }

    public function getTotalProfit(): float|int
    {
        return $this->getProfit();
    }

    private function getEmployeeRate(): float|int
    {
        return  $this->item->events->getRate();
    }

    private function getEmployeePrice(): float|int
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
        return $this->getDiscountedPrice() * $this->getEmployeeRate();
    }

}
