<?php


namespace schedule\entities\behaviors;


use schedule\entities\Schedule;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ScheduleWorkBehavior extends Behavior
{
    public $attribute = 'schedule';
    public $jsonAttribute = 'schedule_json';

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    public function onAfterFind(Event $event): void
    {
        $model = $event->sender;
        $schedule = Json::decode($model->getAttribute($this->jsonAttribute));
        $model->{$this->attribute} = new Schedule(
            ArrayHelper::getValue($schedule, 'hoursWork'),
            ArrayHelper::getValue($schedule, 'weekends'),
            ArrayHelper::getValue($schedule, 'week'),
        );
    }


    /**
     * @param Event $event
     */
    public function onBeforeSave(Event $event): void
    {
        $model = $event->sender;
        $model->setAttribute(
            'schedule_json',
            Json::encode(
                [
                    'hoursWork' => $model->{$this->attribute}->hoursWork,
                    'weekends' => $model->{$this->attribute}->weekends,
                    'week' => $model->{$this->attribute}->week,
                ]
            )
        );
    }
}