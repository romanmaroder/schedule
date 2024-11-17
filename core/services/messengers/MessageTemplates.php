<?php


namespace core\services\messengers;


use core\helpers\DateHelper;
use core\helpers\ServiceHelper;
use core\helpers\tHelper;
use yii\helpers\ArrayHelper;

class MessageTemplates
{
    public const ADDRESS_MESSAGE = 'Address';
    public const REMAINDER_MESSAGE = 'Remind';
    public const QUESTION_MESSAGE = 'Question';
    public const PRICE_MESSAGE = 'Price';
    public const TOTAL_PRICE_MESSAGE = 'Total';
    public const INFO = 'info';


    public function checkMessage($flag, $data): string
    {
        switch ($flag) {
            case FlagsTemplates::REMAINDER:
                return Greeting::checkGreeting() . tHelper::translate(
                        'sms',
                        self::REMAINDER_MESSAGE
                    ) . DateHelper::formatter(
                        $data->start
                    );
            case FlagsTemplates::ADDRESS:
                return Greeting::checkGreeting() . tHelper::translate('sms', self::ADDRESS_MESSAGE);
            case FlagsTemplates::QUESTION:
                return Greeting::checkGreeting() . DateHelper::formatter(
                        $data->start
                    ) . tHelper::translate('sms', self::QUESTION_MESSAGE);
            case FlagsTemplates::PRICE;
                return Greeting::checkGreeting() . tHelper::translate('sms', self::PRICE_MESSAGE). ' ' .
                    ServiceHelper::detailedPriceList($data->serviceAssignments);
            case FlagsTemplates::TOTAL_PRICE;
                return Greeting::checkGreeting() . tHelper::translate('sms', self::TOTAL_PRICE_MESSAGE). ' '
                    . ServiceHelper::priceList($data->serviceAssignments);
            default:
                return '';
        }
        /*return match ($flag) {
            FlagsTemplates::REMAINDER => Greeting::checkGreeting() . tHelper::translate(
                    'sms',
                    self::REMAINDER_MESSAGE
                ) . DateHelper::formatter(
                    $data->start
                ),
            FlagsTemplates::ADDRESS => Greeting::checkGreeting() . tHelper::translate('sms', self::ADDRESS_MESSAGE),
            FlagsTemplates::QUESTION => Greeting::checkGreeting() . DateHelper::formatter(
                    $data->start
                ) . tHelper::translate('sms', self::QUESTION_MESSAGE),
            FlagsTemplates::PRICE => Greeting::checkGreeting() . tHelper::translate('sms', self::PRICE_MESSAGE) . ' ' .
                ServiceHelper::detailedPriceList($data->serviceAssignments),
            FlagsTemplates::TOTAL_PRICE => Greeting::checkGreeting() . tHelper::translate(
                    'sms',
                    self::TOTAL_PRICE_MESSAGE
                ) . ' '
                . ServiceHelper::priceList($data->serviceAssignments),
            default => '',
        };*/
    }


    public function title($flag): string
    {
            return ArrayHelper::getValue(self::titleList(), $flag);

    }

    private static function titleList(): array
    {
        return [
            FlagsTemplates::ADDRESS => tHelper::translate('sms', 'AddressTitle'),
            FlagsTemplates::REMAINDER => tHelper::translate('sms', 'EventTitle'),
            FlagsTemplates::QUESTION => tHelper::translate('sms', 'ConfirmationTitle'),
            FlagsTemplates::PRICE => tHelper::translate('sms', 'PriceTitle'),
            FlagsTemplates::TOTAL_PRICE => tHelper::translate('sms', 'Total'),
            FlagsTemplates::TELEGRAM => tHelper::translate('sms', 'Total'),
            FlagsTemplates::SMS => tHelper::translate('sms', 'Total'),
        ];
    }
}