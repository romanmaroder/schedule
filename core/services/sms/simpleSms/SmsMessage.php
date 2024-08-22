<?php


namespace core\services\sms\simpleSms;


class SmsMessage
{

    public const ADDRESS_MESSAGE = ' Our address: Razdolnaya st. 11, entrance 4, apt. 142, floor 9 ';
    public const REMAINDER_MESSAGE = ' You have the following entry ';
    public const QUESTION_MESSAGE = ' You have a recording. Will you?';

    public const ICON_LOCATION = '<i class="fas fa-map-marker-alt"></i>';
    public const ICON_ENVELOPE = '<i class="far fa-envelope"></i>';
    public const ICON_CONFIRM = '<i class="far fa-question-circle"></i>';


    public function message($ext,$data): string
    {
        switch ($ext) {
            case self::ADDRESS_MESSAGE;
                return Greeting::checkGreeting() . self::ADDRESS_MESSAGE;
            case self::QUESTION_MESSAGE;
                return Greeting::checkGreeting() . ' '.  date('d/M/Y H:i',strtotime($data->start)) . ' ' . self::QUESTION_MESSAGE;
            default:
                return Greeting::checkGreeting() . self::REMAINDER_MESSAGE . ' ' . date('d/M/Y H:i',strtotime($data->start));
        }
        /*return match ($ext) {
            self::ADDRESS_MESSAGE => Greeting::checkGreeting() . self::ADDRESS_MESSAGE,
            self::QUESTION_MESSAGE => Greeting::checkGreeting() . ' ' . mb_substr(
                    $data->start,
                    0,
                    -3
                ) . ' ' . self::QUESTION_MESSAGE,
            default => Greeting::checkGreeting() . self::REMAINDER_MESSAGE . ' ' . mb_substr($data->start, 0, -3),
        };*/
    }

    public function icon($type): string
    {
        switch ($type) {
            case SmsMessage::ADDRESS_MESSAGE:
                return SmsMessage::ICON_LOCATION;
            case SmsMessage::QUESTION_MESSAGE:
                return SmsMessage::ICON_CONFIRM;
            default:
                return SmsMessage::ICON_ENVELOPE;
        }
        /*return match ($text) {
            SmsMessage::ADDRESS_MESSAGE => SmsMessage::ICON_LOCATION,
            SmsMessage::QUESTION_MESSAGE => SmsMessage::ICON_CONFIRM,
            default => SmsMessage::ICON_ENVELOPE,
        };*/
    }
}