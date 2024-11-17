<?php


namespace core\services\messengers;


use core\helpers\tHelper;
use Yii;

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
            case $hour >= 04;
                return tHelper::translate('sms/greeting',self::MORNING);
            case $hour >= 10;
                return tHelper::translate('sms/greeting',self::DAY);
            case $hour >= 16;
                return tHelper::translate('sms/greeting',self::EVENING);
            case ($hour >= 02 or $hour <= 04);
                return tHelper::translate('sms/greeting',self::NIGHT);
        }

    }
}