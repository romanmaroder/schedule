<?php


namespace core\services\bots\classes;



use core\services\bots\classes\telegram\Event;
use core\services\bots\interfaces\BotInterface;

class BotMessenger
{
    public function Telegram():BotInterface
    {
        return new Event();
    }
}