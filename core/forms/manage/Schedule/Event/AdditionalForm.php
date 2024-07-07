<?php


namespace core\forms\manage\Schedule\Event;


use core\entities\Schedule\Event\Event;
use core\entities\Schedule\Additional\Additional;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AdditionalForm extends Model
{
    public array $lists = [];

    public function __construct(Event $event = null, $config = [])
    {
        if ($event) {
            $this->lists = ArrayHelper::getColumn($event->serviceAssignments, 'service_id');
        }
        parent::__construct($config);
    }

    public function servicesList(): array
    {
        return ArrayHelper::map(Additional::find()->active()->all(), 'id', 'name');
    }

    public function rules()
    {
        return [
            ['lists', 'each', 'rule' => ['integer']],
            ['lists', 'default', 'value' => []],
            ['lists','required']
        ];
    }

}