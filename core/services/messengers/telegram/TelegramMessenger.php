<?php


namespace core\services\messengers\telegram;


use core\services\messengers\Icon;
use core\services\messengers\interfaces\IconInterface;
use core\services\messengers\Message;
use core\services\messengers\interfaces\MessageInterface;
use core\services\messengers\interfaces\MessengerFactoryInterface;
use core\services\messengers\RenderButton;
use core\services\messengers\interfaces\RenderInterface;

class TelegramMessenger implements MessengerFactoryInterface
{
    public $flag;
    public $data;

    /**
     * SmsMessenger constructor.
     * @param $flag
     * @param $data
     */
    public function __construct($flag, $data)
    {
        $this->flag = $flag;
        $this->data = $data;
    }
    public function buildMessage(): MessageInterface
    {
        return new Message($this->flag,$this->data);
    }

    public function buildIcon(): IconInterface
    {
        return new Icon($this->flag);
    }

    public function buildRender(): RenderInterface
    {
        return new RenderTelegram(
            $this->buildIcon()->icon(),
            $this->buildMessage()->message(),
            $this->buildMessage()->title(),
            $this->data
        );

    }

    public function buildTrigger(): RenderInterface
    {
        return new RenderButton(
            $this->buildIcon()->icon(),
            $this->flag
        );
    }
}