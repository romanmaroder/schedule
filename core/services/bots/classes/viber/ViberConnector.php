<?php


namespace core\services\bots\classes\viber;


use core\services\bots\interfaces\BotConnector;

/**
 * Этот Конкретный Продукт реализует API Viber.
 */
class ViberConnector implements BotConnector
{

    public function send($content)
    {
        return __CLASS__;
    }
}