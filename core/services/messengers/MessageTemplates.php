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


    public function checkMessage($flag, $data, $greeting = true): string
    {
        switch ($flag) {
            case FlagsTemplates::REMAINDER:
                return $this->RemindMessage($data);
            case FlagsTemplates::ADDRESS:
                return $this->AddressMessage();
            case FlagsTemplates::QUESTION:
                return $this->QuestionMessage($data);
            case FlagsTemplates::PRICE;
                return $this->PriceMessage($data,$greeting);
            case FlagsTemplates::TOTAL_PRICE;
                return $this->PriceTotalMessage($data,$greeting);
            default:
                throw new \Exception('No such template exists.');
        }
        /*return match ($flag) {
            FlagsTemplates::REMAINDER => $this->RemindMessage($data),
            FlagsTemplates::ADDRESS => $this->AddressMessage(),
            FlagsTemplates::QUESTION => $this->QuestionMessage($data),
            FlagsTemplates::PRICE => $this->PriceMessage($data),
            FlagsTemplates::TOTAL_PRICE => $this->PriceTotalMessage($data),
            default => throw new \Exception('No such template exists.'),
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

    private function AddressMessage():string
    {
        return Greeting::checkGreeting() . tHelper::translate('sms', self::ADDRESS_MESSAGE);
    }

    private function RemindMessage($data):string
    {
        return Greeting::checkGreeting() . tHelper::translate(
                'sms',
                self::REMAINDER_MESSAGE
            ) . DateHelper::formatter(
                $data->start
            );
    }

    private function QuestionMessage($data):string
    {
        return Greeting::checkGreeting() . DateHelper::formatter(
                $data->start
            ) . tHelper::translate('sms', self::QUESTION_MESSAGE);
    }

    private function PriceMessage($data, $greeting = true): string
    {
        if ($greeting == false) {
            return tHelper::translate('sms', self::PRICE_MESSAGE) . ' ' .
                ServiceHelper::detailedPriceList($data->serviceAssignments);
        }
        return Greeting::checkGreeting() . tHelper::translate('sms', self::PRICE_MESSAGE) . ' ' .
            ServiceHelper::detailedPriceList($data->serviceAssignments);
    }

    private function PriceTotalMessage($data, $greeting = true): string
    {
        if ($greeting == false) {
            return tHelper::translate('sms', self::TOTAL_PRICE_MESSAGE) . ' '
                . ServiceHelper::priceList($data->serviceAssignments);
        }
        return Greeting::checkGreeting() . tHelper::translate('sms', self::TOTAL_PRICE_MESSAGE) . ' '
            . ServiceHelper::priceList($data->serviceAssignments);
    }
}