<?php


namespace core\dispatchers;


interface EventDispatcher

{
    public function dispatchAll(array $events): void;
    public function dispatch($event): void;
}