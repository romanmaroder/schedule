<?php


namespace schedule\entities;


class Schedule
{
    public $hoursWork;
    public $weekends;

    /**
     * Schedule constructor.
     * @param $hoursWork
     * @param $weekends
     */
    public function __construct($hoursWork, $weekends,)
    {
        $this->hoursWork = $hoursWork;
        $this->weekends = $weekends;
    }

    public static function scheduleDays(): array
    {
        return (new ScheduleItem())->days();
    }

    /**
     * List of weekends
     * @param array $days
     * @return array
     */
    public static function getScheduleDays(array $days): array
    {
        return $result = array_intersect_key(self::scheduleDays(), array_flip($days));
    }

    public static function scheduleHours(): array
    {
        return (new ScheduleItem())->hours();
    }

    /**
     * List of working hours
     * @param array $hours
     * @return array
     */
    public static function getScheduleHours(array $hours): array
    {
        return $result = array_intersect_key(self::scheduleHours(), array_flip($hours));
    }

    /**
     * @param array $hours
     * @return array
     */
    public function disabledHours(array $hours): array
    {
        return array_keys(array_diff_key(self::scheduleHours(),array_flip($hours)));
    }


}