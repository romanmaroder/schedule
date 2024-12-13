<?php


namespace core\services\messengers;


use core\services\messengers\interfaces\MessengerFactoryInterface;
use core\services\messengers\sms\SmsMessenger;
use core\services\messengers\telegram\TelegramMessenger;
/**
 * Class MessengerFactory
 *
 * Class for creating factories for drawing SMS or telegram notification buttons
 */
class MessengerFactory
{
    /**
     * @param string $type - messenger type
     * @param string $flag - \core\services\messengers\FlagsTemplates
     * @param object|null $data - \core\entities\Schedule\Event\Event
     * @return MessengerFactoryInterface
     * @throws \Exception
     */
    public function build(string $type, string $flag, object $data = null): MessengerFactoryInterface
    {
        switch (strtolower($type)) {
            case "sms":
                $messenger = new SmsMessenger($flag, $data);
                break;
            case "telegram":
                $messenger = new TelegramMessenger($flag, $data);
                break;
            default:
                throw new \Exception('Messenger type is not defined.');
        }
        return $messenger;
    }
}