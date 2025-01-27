<?php


namespace core\cart\schedule;


use core\cart\schedule\storage\StorageInterface;
use core\entities\Enums\PaymentOptionsEnum;

class CartWithParams
{

    /**
     * @var CartItem[]
     * */
    private $items;
    private $params;

    public function __construct(private readonly StorageInterface $storage)
    {
    }

    /**
     * @return CartItem[]
     */
    public function getItems(): array
    {
        $this->loadItems();
        return $this->items;
    }

    public function getFullSalary(): int|float
    {
        $this->loadItems();
        return array_sum(array_map(fn(CartItem $item) => $item->getSalary(), $this->items));
    }

    public function getFullProfit(): int|float
    {
        $this->loadItems();
        return array_sum(array_map(fn(CartItem $item) => $item->getTotalProfit(), $this->items));
    }

    public function getFullDiscountedCost(): float|int
    {
        $this->loadItems();
        return array_sum(array_map(fn(CartItem $item) => $item->getDiscountedPrice(), $this->items));
    }

    /**
     * The total amount of the type of source of receipt of funds including costs
     *
     * Общая сумма по типу источника поступления средств включая зарплату и затраты
     *
     * Карта не учитывает заработную плату. Придумать логику учета заработной платы из безнала
     * @param PaymentOptionsEnum $type
     * @param float|null $expense
     * @return float|int
     */
    public function getAmountIncludingSalaryExpenses(PaymentOptionsEnum $type, float|null $expense): float|int
    {
        return match ($type) {
            PaymentOptionsEnum::STATUS_CASH => $this->getCash() - $this->getFullSalary() - $expense,
            PaymentOptionsEnum::STATUS_CARD => $this->getCard() - $expense, //TODO
            default => 0,
        };
    }

    /**
     * Total cash
     * Общая сумма наличных средств
     * @return float|int
     */
    public function getCash(): float|int
    {
        $this->loadItems();
        return array_sum(array_map(fn(CartItem $item) => $item->getCash(), $this->items));
    }

    /**
     * Total amount of non-cash funds
     * Общая сумма безналичных средств
     * @return float|int
     */
    public function getCard(): float|int
    {
        $this->loadItems();
        return array_sum(array_map(fn(CartItem $item) => $item->getCard(), $this->items));
    }

    /*public function getCost(): Cost
    {
        $this->loadItems();
        return $this->calculator->getCost($this->items);
    }*/

    /*public function add(CartItem $item): void
    {
        $this->loadItems();
        foreach ($this->items as $i => $current) {
            if ($current->getId() == $item->getId()) {
                $this->items[$i] = $current->plus($item->getQuantity());
                $this->saveItems();
                return;
            }
        }
        $this->items[] = $item;
        $this->saveItems();
    }

    public function set($id, $quantity): void
    {
        $this->loadItems();
        foreach ($this->items as $i => $current) {
            if ($current->getId() == $id) {
                $this->items[$i] = $current->changeQuantity($quantity);
                $this->saveItems();
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function remove($id): void
    {
        $this->loadItems();
        foreach ($this->items as $i => $current) {
            if ($current->getId() == $id) {
                unset($this->items[$i]);
                $this->saveItems();
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function clear(): void
    {
        $this->items = [];
        $this->saveItems();
    }*/
    /**
     * Parameters for sampling from the database
     * Параметры для выборки из БД
     * @param array $params
     * @return array
     */
    public function setParams(array $params): array
    {
        return $this->params = $params;
    }

    /**
     * Data loading from a database with parameters
     * Загрузка данных из БД с параметрами
     * @return void
     */
    private function loadItems(): void
    {
        if ($this->items === null) {
            $this->items = $this->storage->loadWithParams($this->params);
        }
    }

    private function saveItems(): void
    {
        // $this->storage->save($this->items);
    }

}