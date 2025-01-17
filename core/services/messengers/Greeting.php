<?php


namespace core\services\messengers;


use core\helpers\tHelper;

class Greeting
{
    protected const MORNING = "Morning";
    protected const DAY = "Afternoon";
    protected const EVENING = "Evening";
    protected const NIGHT = "Night";


    /**
     * Checking the time of day for the greeting
     *
     * @return string
     */
    public static function checkGreeting(): string
    {
        $hour = date("H A");
        switch ($hour) {
            case ($hour >= 04) && ($hour <= 10);
                return tHelper::translate('sms/greeting',self::MORNING);
            case ($hour >= 10) && ($hour <= 16);
                return tHelper::translate('sms/greeting',self::DAY);
            case ($hour >= 16) && ($hour <= 20);
                return tHelper::translate('sms/greeting',self::EVENING);
            case  ($hour >= 20);
                return tHelper::translate('sms/greeting',self::NIGHT);
        }
        return tHelper::translate('sms/greeting',self::NIGHT);
    }
}