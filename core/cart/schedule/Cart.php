<?php


namespace core\cart\schedule;



use core\cart\schedule\storage\StorageInterface;

class Cart
{

    /**
     * @var CartItem[]
     * */
    private $items;

    public function __construct( private  readonly StorageInterface $storage){}

    /**
     * @return CartItem[]
     */
    public function getItems(): array
    {
        $this->loadItems();
        return $this->items;
    }

    public function getAmount(): int
    {
        $this->loadItems();
        return count($this->items);
    }

    public function getFullSalary(): int|float
    {
        $this->loadItems();
        return array_sum(array_map(fn (CartItem $item) =>$item->getSalary(), $this->items));
    }

    public function getFullProfit(): int|float
    {
        $this->loadItems();
        return array_sum(array_map(fn (CartItem $item)=> $item->getTotalProfit(), $this->items));
    }


    public function getFullDiscountedCost(): float|int
    {
        $this->loadItems();
        return array_sum(array_map(fn (CartItem $item)=>$item->getDiscountedPrice(), $this->items));
    }

    public function getTotalWithSubtractions($expense): float|int
    {
        return $this->getFullProfit() - $expense ;
    }


    public function getCash(): float|int
    {
        $this->loadItems();
        return array_sum(array_map(fn (CartItem $item) =>$item->getCash(), $this->items));
    }

    public function getCard(): float|int
    {
        $this->loadItems();
        return array_sum(array_map(fn (CartItem $item) =>$item->getCard(), $this->items));
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

    private function loadItems(): void
    {
        if ($this->items === null) {
            $this->items = $this->storage->load();
        }
    }

    private function saveItems(): void
    {
       // $this->storage->save($this->items);
    }

}