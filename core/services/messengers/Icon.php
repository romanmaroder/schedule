<?php


namespace core\services\messengers;



use core\services\messengers\interfaces\IconInterface;

class Icon implements IconInterface
{
    public $flag;
    /**
     * IconSms constructor.
     * @param $flag
     */
    public function __construct($flag)
    {
        $this->flag = $flag;
    }

    public function icon():string
    {
        return (new IconTemplates())->checkIcon($this->flag);
    }
}