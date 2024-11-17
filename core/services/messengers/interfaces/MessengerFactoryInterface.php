<?php


namespace core\services\messengers\interfaces;
/**
 * Интерфейс Абстрактной фабрики объявляет создающие методы для каждого
 * определённого типа продукта.
 */

interface MessengerFactoryInterface
{
    public function buildMessage():MessageInterface;

    public function buildIcon(): IconInterface;

    public function buildRender(): RenderInterface;

    public function buildTrigger(): RenderInterface;
}