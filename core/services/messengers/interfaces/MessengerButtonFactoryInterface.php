<?php


namespace core\services\messengers\interfaces;

/**
 * Интерфейс Абстрактной фабрики объявляет создающие методы для каждого
 * определённого типа продукта.
 */
interface MessengerButtonFactoryInterface
{
    public function buildButton(): RenderInterface;

    public function buildIcon(): IconInterface;
}