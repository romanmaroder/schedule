<?php


namespace core\services\sms\simpleSms;


use Yii;

class Greeting
{
    protected const MORNING = "Good morning." . PHP_EOL;
    protected const DAY = "Good afternoon." . PHP_EOL;
    protected const EVENING = "Good evening." . PHP_EOL;
    protected const NIGHT = "Good night." . PHP_EOL;


    /**
     * Checking the time of day for the greeting
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function checkGreeting(): string
    {
        $hour = date("H:i");

        switch ($hour) {
            case $hour >= 04;
                return self::MORNING;
            case $hour >= 10;
                return self::DAY;
            case $hour >= 16;
                return self::EVENING;
            case ($hour >= 2 or $hour < 04);
                return self::NIGHT;
        }

    }
}