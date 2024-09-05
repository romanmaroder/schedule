<?php


namespace core\forms\manage\Schedule\Event;


use core\entities\Schedule\Event\Event;
use core\entities\Schedule\Service\Service;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ServicesForm extends Model
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
        return ArrayHelper::map(Service::find()->joinWith('category')->active()->all(),
                                'id',
                                'name',
                                'category.parent.name'
        );

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