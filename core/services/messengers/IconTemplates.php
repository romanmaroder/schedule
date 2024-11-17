<?php


namespace core\services\messengers;


class IconTemplates
{
    public const ICON_LOCATION = '<i class="fas fa-map-marker-alt"></i>';
    public const ICON_ENVELOPE = '<i class="far fa-envelope"></i>';
    public const ICON_CONFIRM = '<i class="far fa-question-circle"></i>';
    public const ICON_PRICE = '<i class="fas fa-dollar-sign"></i>';
    public const ICON_TOTAL_PRICE = '<i class="fas fa-wallet"></i>';
    public const ICON_SMS = '<i class="fas fa-sms"></i>';
    public const ICON_TELEGRAM = '<i class="fab fa-telegram-plane"></i>';


    public function checkIcon($flag): string
    {
        switch ($flag) {
            case FlagsTemplates::ADDRESS:
                return self::ICON_LOCATION;
            case FlagsTemplates::REMAINDER:
                return self::ICON_ENVELOPE;
            case FlagsTemplates::QUESTION:
                return self::ICON_CONFIRM;
            case FlagsTemplates::PRICE;
                return self::ICON_PRICE;
            case FlagsTemplates::TOTAL_PRICE;
                return self::ICON_TOTAL_PRICE;
            case FlagsTemplates::SMS;
                return self::ICON_SMS;
            case FlagsTemplates::TELEGRAM;
                return self::ICON_TELEGRAM;
            default:
                return '';
        }
        /*return match ($flag) {
            FlagsTemplates::ADDRESS => self::ICON_LOCATION,
            FlagsTemplates::REMAINDER => self::ICON_ENVELOPE,
            FlagsTemplates::QUESTION => self::ICON_CONFIRM,
            FlagsTemplates::PRICE => self::ICON_PRICE,
            FlagsTemplates::SMS => self::ICON_SMS,
            FlagsTemplates::TELEGRAM => self::ICON_TELEGRAM,
            default => '',
        };*/
    }
}