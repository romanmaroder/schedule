<?php


namespace schedule\helpers;


use schedule\entities\Schedule;

class ScheduleHelper
{


    public static function days(): array
    {
        return Schedule::scheduleDays();
    }

    public static function hours(): array
    {
        return Schedule::scheduleHours();
    }

    public static function getWeekends(array $days): string
    {
        if (is_array($days)) {
            return implode(', ', Schedule::getScheduleDays($days));
        }
        throw new \DomainException('The passed argument must be an array.');
    }

    public static function getWorkingHours(array $hours): string
    {
        if (is_array($hours)) {
            return implode(', ', Schedule::getScheduleHours($hours));
        }
        throw new \DomainException('The passed argument must be an array.');
    }
}