<?php

namespace core\cart\schedule;

use core\cart\schedule\discount\Discount;
use core\entities\Schedule\Event\ServiceAssignment;

/**
 *
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
    public function getOriginalCost(): int|null
    {
        return $this->item->original_cost;
    }

    /**
     * The price of the service takes into account the price of the master
     * @return float|int
     */
    public function getMasterPrice(): float|int
    {
        #Rounding up
        //return round($this->getOriginalCost() * $this->getEmployeePrice(),-2,PHP_ROUND_HALF_EVEN);
        //return $this->getOriginalCost() * $this->getEmployeePrice();
        //return $this->getOriginalCost() - $this->getEmployeePrice();
        return $this->item->price_cost;
    }

    /**
     * Discounted service price
     * @return float|int
     */

    public function getDiscountedPrice(): float|int
    {
        switch ($this->getDiscountFrom()) {
            case Discount::MASTER_DISCOUNT:
                $discountedPrice = $this->getMasterPrice() - $this->masterDiscount();
                break;
            case Discount::STUDIO_DISCOUNT:
                $discountedPrice = $this->getMasterPrice() - ($this->getMasterPrice() * $this->getDiscount() / 100);
                break;
            default:
                $discountedPrice = ceil(
                    $this->getMasterPrice() - ($this->getMasterPrice() * $this->getEmployeeRate() *
                        ($this->getDiscount() / 100))
                );
        }

        /*$discountedPrice = match ($this->getDiscountFrom()) {
            Discount::MASTER_DISCOUNT => $this->getMasterPrice() - $this->masterDiscount(),
            Discount::STUDIO_DISCOUNT => $this->getMasterPrice() - ($this->getMasterPrice() * $this->getDiscount(
                    ) / 100),
            default => ceil(
                $this->getMasterPrice() - ($this->getMasterPrice() * $this->getEmployeeRate() *
                    ($this->getDiscount() / 100))
            ),
        };*/

        return $discountedPrice;
    }

    public function getDiscountFrom(): float|int
    {
        return $this->item->events->discount_from;
    }

    /**
     * Salary calculation
     * @return float|int
     */
    public function getCost(): float|int
    {
        switch ($this->getDiscountFrom()) {
            case Discount::NO_DISCOUNT:
                $cost = $this->costNoDiscount();
                break;
            case Discount::MASTER_DISCOUNT:
                $cost = $this->costMasterDiscount();
                break;
            case Discount::STUDIO_DISCOUNT:
                $cost = $this->costStudioDiscount();
                break;
            case Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK :
                $cost = $this->getCostDiscountFromTheStudioWithMaster();
                break;
            default:
                $cost = $this->costNoDiscount();
        }

        /* $cost = match ($this->getDiscountFrom()) {
            Discount::NO_DISCOUNT => $this->costNoDiscount(),
            Discount::MASTER_DISCOUNT => $this->costMasterDiscount(),
            Discount::STUDIO_DISCOUNT => $this->costStudioDiscount(),
            Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK => $this->getCostDiscountFromTheStudioWithMaster(),
            default => $this->costNoDiscount(),
        };*/

        return $cost;
    }

    /**
     * Profit calculation
     * @return float|int
     */
    public function getProfit(): float|int
    {
        switch ($this->getDiscountFrom()) {
            case Discount::NO_DISCOUNT:
                $profit = $this->profitNoDiscount();
                break;
            case Discount::MASTER_DISCOUNT:
                $profit = $this->profitMasterDiscount();
                break;
            case Discount::STUDIO_DISCOUNT:
                $profit = $this->profitStudioDiscount();
                break;
            case Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK:
                $profit = $this->getProfitDiscountFromTheStudioWithMaster();
                break;
            default:
                $profit = $this->profitNoDiscount();
        }
        /* $profit = match ($this->getDiscountFrom()) {
            Discount::NO_DISCOUNT => $this->profitNoDiscount(),
            Discount::MASTER_DISCOUNT => $this->profitMasterDiscount(),
            Discount::STUDIO_DISCOUNT => $this->profitStudioDiscount(),
            Discount::STUDIO_DISCOUNT_WITH_MASTER_WORK => $this->getProfitDiscountFromTheStudioWithMaster(),
            default => $this->profitNoDiscount(),
        };
        };*/

        return $profit;
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
        return $this->item->events->getRate();
    }

    /**
     * Discount from the master
     * To calculate the price with a discount from the master
     * @return float|int
     */
    private function masterDiscount(): float|int
    {
        if ($this->checkFullDiscount()) {
            return $this->getMasterPrice() * $this->getEmployeeRate();
        }
        return $this->getMasterPrice() * $this->getEmployeeRate() -
            ($this->getMasterPrice() * $this->getEmployeeRate() * ($this->getDiscount() / 100));
    }

    /**
     * Discount from the master
     * To calculate wages taking into account the discount from the master
     * @return float|int
     */
    private function costMasterDiscount(): float|int
    {
        if ($this->checkFullDiscount()) {
            return 0;
        }
        if ($this->fullRate()) {
            return 0;
        }
        return $this->getMasterPrice() * $this->getEmployeeRate() -
            ($this->getMasterPrice() * $this->getEmployeeRate() * ($this->getDiscount() / 100));
    }

    /**
     * Studio discount
     * @return float|int
     */
    private function costStudioDiscount(): float|int
    {
        if ($this->fullRate()) {
            return 0;
        }
        return $this->getDiscountedPrice() * $this->getEmployeeRate();
    }

    /**
     * Cost no discounts
     * If the rate and price of the master == 100%, then the salary is not taken into account
     * @return float|int
     */
    private function costNoDiscount(): float|int
    {
        if ($this->fullRate()) {
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
        if ($this->fullRate()) {
            return 0;
        }
        return $this->getMasterPrice() * $this->getEmployeeRate();
    }

    private function getProfitDiscountFromTheStudioWithMaster(): float|int
    {
        return $this->getMasterPrice() * $this->getEmployeeRate() - ($this->getMasterPrice() *
                $this->getEmployeeRate() * $this->getDiscount() / 100);
    }

    /**
     * No discounts
     * Profit calculation without discounts
     * @return float|int
     */
    private function profitNoDiscount(): float|int
    {
        if ($this->fullRate()) {
            return $this->getMasterPrice() * $this->getEmployeeRate();
        }
        return $this->getMasterPrice() - $this->getSalary();
    }

    /**
     * Discount from the master
     * Profit calculation with a discount from the master
     * @return float|int
     */
    private function profitMasterDiscount(): float|int
    {
        if ($this->fullRate()) {
            if ($this->checkFullDiscount()) {
                return 0;
            }
            return $this->getMasterPrice() - $this->getDiscountedPrice();
        }

        return $this->getMasterPrice() * $this->getEmployeeRate();
    }

    /**
     * Discount from the studio
     * @return float|int
     * Calculation of profit with studio discount
     */
    private function profitStudioDiscount(): float|int
    {
        if ($this->fullRate()) {
            if ($this->checkFullDiscount()) {
                return 0;
            }
            return $this->getDiscountedPrice();
        }
        return $this->getDiscountedPrice() - $this->getSalary();
    }

    private function fullRate(): bool
    {
       
        if ($this->getEmployeeRate() == 1) {
            return true;
        }
        return false;
    }

    private function checkFullDiscount(): bool
    {
        if ($this->getDiscount() == 100) {
            return true;
        }
        return false;
    }
}
