<?php


namespace schedule\entities;


class Schedule
{
    public $hoursWork;
    public $weekends;
    public $week;

    /**
     * Schedule constructor.
     * @param $hoursWork
     * @param $weekends
     * @param $week
     */
    public function __construct($hoursWork, $weekends, $week)
    {
        $this->hoursWork = $hoursWork;
        $this->weekends = $weekends;
        $this->week = $week;
    }

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
            return $result = array_intersect_key(self::scheduleDays(), array_flip($days));
        }
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
            return $result = array_intersect_key(self::scheduleHours(), array_flip($hours));
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