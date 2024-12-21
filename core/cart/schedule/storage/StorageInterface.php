<?php


namespace core\cart\schedule\storage;


use core\cart\schedule\CartItem;

interface StorageInterface
{
    /**
     * @return \core\cart\schedule\CartItem[]
     */
    public function load(): array;

    public function loadWithParams(array $params): array;

    /**
     * @param \core\cart\schedule\CartItem[] $items
     */
    public function save(array $items): void;
}