<?php


namespace core\cart\storage;


use core\cart\CartItem;

interface StorageInterface
{
    /**
     * @return \core\cart\CartItem[]
     */
    public function load(): array;

    /**
     * @param \core\cart\CartItem[] $items
     */
    public function save(array $items): void;
}