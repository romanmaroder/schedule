<?php


namespace core\services\messengers;



use core\services\messengers\interfaces\MessageInterface;

class Message implements MessageInterface
{
    public $flag;
    public $data;

    /**
     * MessageSms constructor.
     * @param $flag
     * @param $data
     */
    public function __construct($flag,$data)
    {
        $this->flag = $flag;
        $this->data = $data;
    }

    public function message():string
    {
        return (new MessageTemplates())->checkMessage($this->flag,$this->data);
    }

    public function title():string
    {
        return (new MessageTemplates())->title($this->flag);
    }
}