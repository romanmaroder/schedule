<?php


namespace core\forms\manage;


use core\entities\Schedule;
use core\helpers\tHelper;
use yii\base\Model;

class ScheduleForm extends Model
{
    public $hoursWork;
    public $weekends;
    public $week;

    public function __construct(Schedule $schedule = null, $config = [])
    {
        if ($schedule) {
            $this->hoursWork = $schedule->hoursWork;
            $this->weekends = $schedule->weekends;
            $this->week = $schedule->week;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['hoursWork', 'each', 'rule' => ['integer']],
            ['weekends', 'each', 'rule' => ['integer']],
            [['week'],'string','max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'hoursWork'=>tHelper::t('user/schedule','Hours'),
            'weekends'=>tHelper::t('user/schedule','Weekends'),
            'days'=>tHelper::t('user/schedule','Days'),
            'week'=>tHelper::t('user/schedule','Week'),
        ];
    }
}