<?php


namespace core\services\bots\classes\viber;


use core\services\bots\classes\Bot;
use core\services\bots\interfaces\BotConnector;

class ViberBot extends Bot
{

    public function getMessengerBot(): BotConnector
    {
        return new ViberConnector();
    }
}