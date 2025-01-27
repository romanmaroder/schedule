<?php

namespace core\cart\schedule;

use core\entities\Enums\DiscountEnum;
use core\entities\Enums\PaymentOptionsEnum;
use core\entities\Schedule\Event\ServiceAssignment;

class CartItem
{
    public function __construct(private $item)
    {
    }

    public function getEvents(): ServiceAssignment
    {
        return $this->item;
    }

    public function getId(): int
    {
        return $this->item->events->id;
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

    public function getPayment(): int
    {
        return $this->item->events->payment;
    }

    public function getCash(): float|int
    {
        if ($this->item->events->isCashPayment() && $this->item->events->isPayed()) {
            return $this->getDiscountedPrice();
        }
        return false;
    }

    public function getCard(): float|int
    {
        if ($this->item->events->isCardPayment() && $this->item->events->isPayed()) {
            return $this->getDiscountedPrice();
        }
        return false;
    }

    /**
     * DiscountEnum
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
        return $this->item->price_cost;
    }

    /**
     * Discounted service price
     * @return float|int
     */

    public function getDiscountedPrice(): float|int
    {
        return match ($this->getDiscountFrom()) {
            DiscountEnum::MASTER_DISCOUNT->value => $this->getMasterPrice() - $this->masterDiscount(),
            DiscountEnum::STUDIO_DISCOUNT->value => $this->getMasterPrice() - ($this->getMasterPrice(
                    ) * $this->getDiscount() / 100),
            default =>
                $this->getMasterPrice() - ($this->getMasterPrice() * $this->getEmployeeRate() *
                    ($this->getDiscount() / 100)
                ),
        };
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
        return match ($this->getDiscountFrom()) {
            DiscountEnum::MASTER_DISCOUNT->value => $this->costMasterDiscount(),
            DiscountEnum::STUDIO_DISCOUNT->value => $this->costStudioDiscount(),
            DiscountEnum::STUDIO_DISCOUNT_WITH_MASTER_WORK->value => $this->getCostDiscountFromTheStudioWithMaster(),
            default => $this->costNoDiscount(),
        };
    }

    /**
     * Profit calculation
     * @return float|int
     */
    public function getProfit(): float|int
    {
        return match ($this->getDiscountFrom()) {
            DiscountEnum::MASTER_DISCOUNT->value => $this->profitMasterDiscount(),
            DiscountEnum::STUDIO_DISCOUNT->value => $this->profitStudioDiscount(),
            DiscountEnum::STUDIO_DISCOUNT_WITH_MASTER_WORK->value => $this->getProfitDiscountFromTheStudioWithMaster(),
            default => $this->profitNoDiscount(),
        };
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
