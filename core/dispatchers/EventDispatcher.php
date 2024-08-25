<?php


namespace core\dispatchers;


interface EventDispatcher

{
    public function dispatch($event): void;
}