<?php


namespace core\cart\schedule\cost;



use core\entities\Enums\DiscountEnum;



final readonly class Cost
{
    public function __construct(private float $value, private array $discounts = [])
    {}

    public function withDiscount(DiscountEnum $discount): self
    {
        return new Cost($this->value, array_merge($this->discounts, [$discount]));
    }

    public function getOrigin(): float
    {
        return $this->value;
    }

    public function getTotal(): float
    {
        return $this->value - array_sum(array_map(function (DiscountEnum $discount) {
                return $discount->getValue();
            }, $this->discounts));
    }

    /**
     * @return DiscountEnum[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }
}