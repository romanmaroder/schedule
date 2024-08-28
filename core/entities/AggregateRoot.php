<?php


namespace core\entities;


interface AggregateRoot
{
    /**
     * @return array
     */
    public function releaseEvents(): array;
}