<?php


namespace core\entities;

class Schedule
{
    /**
     * Schedule constructor.
     * @param $hoursWork
     * @param $weekends
     * @param $week
     */
    public function __construct(public $hoursWork, public $weekends, public $week)
    {}

    public static function scheduleDays(): array
    {
        return (new ScheduleItem())->days();
    }

    /**
     * List of weekends
     * @param  $days
     * @return array
     */
    public static function getScheduleDays($days): array
    {
        if (is_array($days)) {
            return array_intersect_key(self::scheduleDays(), array_flip($days));
        }
        return [];
    }

    public static function scheduleHours(): array
    {
        return (new ScheduleItem())->hours();
    }

    /**
     * List of working hours
     * @param  $hours
     * @return array
     */
    public static function getScheduleHours($hours): array
    {
        if (is_array($hours)) {
            return array_intersect_key(self::scheduleHours(), array_flip($hours));
        }
        return [];
    }

    /**
     * @param  $hours
     * @return array
     */
    public function disabledHours($hours): array
    {
        if (is_array($hours)) {
            return array_keys(array_diff_key(self::scheduleHours(), array_flip($hours)));
        }
        return [];
    }


}