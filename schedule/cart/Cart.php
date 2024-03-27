<?php


namespace schedule\cart;



use schedule\cart\storage\StorageInterface;

class Cart
{

    private $storage;
    /**
     * @var CartItem[]
     * */
    private $items;

    public function __construct( StorageInterface $storage,)
    {
        $this->storage = $storage;
    }

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
        return array_sum(array_map(function (CartItem $item) {
            return $item->getSalary() ;
        }, $this->items));
    }

    public function getFullProfit(): int|float
    {
        $this->loadItems();
        return array_sum(array_map(function (CartItem $item) {
            return $item->getProfit() ;
        }, $this->items));
    }

    public function getFullDiscountedPrice(): int|float
    {
        $this->loadItems();
        return array_sum(array_map(function (CartItem $item) {
            return $item->getDiscountedPrice() ;
        }, $this->items));
    }

    public function getFullDiscountedCost(): int|float
    {
        $this->loadItems();
        return array_sum(array_map(function (CartItem $item) {
            return $item->getDiscountCost() ;
        }, $this->items));
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