<?php


namespace core\services\sms\simpleSms;


use core\helpers\DateHelper;
use core\helpers\ServiceHelper;
use core\helpers\tHelper;

class SmsMessage
{

    public const ADDRESS_MESSAGE = 'Address';
    public const REMAINDER_MESSAGE = 'Remind';
    public const QUESTION_MESSAGE = 'Question';
    public const PRICE_MESSAGE = 'Price';
    public const INFO = 'info';
    public const GROUP = 'group';

    public const ICON_LOCATION = '<i class="fas fa-map-marker-alt"></i>';
    public const ICON_ENVELOPE = '<i class="far fa-envelope"></i>';
    public const ICON_CONFIRM = '<i class="far fa-question-circle"></i>';
    public const ICON_PRICE = '<i class="fas fa-dollar-sign"></i>';
    public const ICON_INFO = '<i class="fas fa-sms"></i>';


    public function message($text, $data): string
    {
        switch ($text) {
            case self::INFO;
            return false;
            case self::ADDRESS_MESSAGE;
                return Greeting::checkGreeting() . tHelper::translate('sms', self::ADDRESS_MESSAGE);
            case self::QUESTION_MESSAGE;
                return Greeting::checkGreeting() . ' ' . DateHelper::formatter(
                        $data->start
                    ) . '. ' . tHelper::translate('sms', self::QUESTION_MESSAGE);
            case self::PRICE_MESSAGE;
                return Greeting::checkGreeting() . ' ' . tHelper::translate('sms', self::PRICE_MESSAGE) . ' ' .
                        ServiceHelper::priceList($data->serviceAssignments);
            default:
                return Greeting::checkGreeting() . tHelper::translate(
                        'sms',
                        self::REMAINDER_MESSAGE
                    ) . ' ' . DateHelper::formatter($data->start);
        }
        /*return match ($text) {
            self::INFO => false,
            self::ADDRESS_MESSAGE => Greeting::checkGreeting() . tHelper::translate('sms', self::ADDRESS_MESSAGE),
            self::QUESTION_MESSAGE => Greeting::checkGreeting() . ' ' . DateHelper::formatter(
                    $data->start
                ) . '. ' . tHelper::translate('sms', self::QUESTION_MESSAGE),
            self::PRICE_MESSAGE => Greeting::checkGreeting() . ' ' . tHelper::translate(
                    'sms',
                    self::PRICE_MESSAGE
                ) . ' ' .
                ServiceHelper::priceList($data->serviceAssignments),
            default => Greeting::checkGreeting() . tHelper::translate(
                    'sms',
                    self::REMAINDER_MESSAGE
                ) . ' ' . DateHelper::formatter($data->start),
        };*/
    }

    public function icon($type): string
    {
        switch ($type) {
            case SmsMessage::REMAINDER_MESSAGE:
                return SmsMessage::ICON_ENVELOPE;
            case SmsMessage::ADDRESS_MESSAGE:
                return SmsMessage::ICON_LOCATION;
            case SmsMessage::QUESTION_MESSAGE:
                return SmsMessage::ICON_CONFIRM;
            case SmsMessage::PRICE_MESSAGE;
                return SmsMessage::ICON_PRICE;
            default:
                return SmsMessage::ICON_INFO;
        }
        /*return match ($type) {
            SmsMessage::REMAINDER_MESSAGE => SmsMessage::ICON_ENVELOPE,
            SmsMessage::ADDRESS_MESSAGE => SmsMessage::ICON_LOCATION,
            SmsMessage::QUESTION_MESSAGE => SmsMessage::ICON_CONFIRM,
            SmsMessage::PRICE_MESSAGE => SmsMessage::ICON_PRICE,
            default => SmsMessage::ICON_INFO,
        };*/
    }
}