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

    public static function getWeekends($days): string
    {
        if (is_array($days)) {
            return implode(', ', Schedule::getScheduleDays($days));
        }
        return '';
    }

    public static function getWorkingHours($hours): string
    {
        if (is_array($hours)) {
            return implode(', ', Schedule::getScheduleHours($hours));
        }
        return '';
    }
}