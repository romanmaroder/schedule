<?php


namespace core\services\bots\classes\telegram;


use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class TelegramBot extends Api
{
    //public const TELEGRAM_BOT_TOKEN = '1903642753:AAFmzbm0X8khTV-AQmO5HzASFC0I4kX_6mY';
    public const TELEGRAM_BOT_TOKEN = '7847510206:AAEkfhZhsL3rop1ObgP9Cz8IXpydJ9v7tKQ';
    /**
     * TelegramBot constructor.
     * @param null $token
     * @param bool $async
     * @param null $http_client_handler
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function __construct($token = null, $async = false, $http_client_handler = null)
    {

        $token = self::TELEGRAM_BOT_TOKEN;
        parent::__construct($token, $async, $http_client_handler);
    }

    /**
     * Reducing a phone number to the form +7(xx)xxx-xx-xx
     *
     * @param string $phone
     *
     * @return string
     */
    public function convertPhone(string $phone)
    {
        $cleaned = preg_replace('/[^\W*[:digit:]]/', '', $phone);

        if (strlen($phone) == 12) {
            preg_match('/\W*(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/', $cleaned, $matches);
            return "+{$matches[1]} ({$matches[2]}) {$matches[3]}-{$matches[4]}-{$matches[5]}";
        } else {
            return $cleaned;
        }
    }




}