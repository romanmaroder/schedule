<?php


namespace core\services\bots\classes;




use core\services\bots\interfaces\BotInterface;

abstract class Bot implements BotInterface
{
    abstract public function send($params);

}