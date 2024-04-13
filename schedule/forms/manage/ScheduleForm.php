<?php


namespace schedule\forms\manage;


use schedule\entities\Schedule;
use yii\base\Model;

class ScheduleForm extends Model
{
    public $hoursWork;
    public $weekends;

    public function __construct(Schedule $schedule = null, $config = [])
    {
        if ($schedule) {
            $this->hoursWork = $schedule->hoursWork;
            $this->weekends = $schedule->weekends;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['hoursWork', 'each', 'rule' => ['integer']],
            ['weekends', 'each', 'rule' => ['integer']],
        ];
    }
}