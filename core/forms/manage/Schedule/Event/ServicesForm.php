<?php


namespace core\forms\manage\Schedule\Event;


use core\entities\Schedule\Event\Event;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ServicesForm extends Model
{
    public array $lists = [];
    private array $services=[];

    public function __construct(Event $event = null, $config = [])
    {
        if ($event) {
            $this->lists = ArrayHelper::getColumn($event->serviceAssignments, 'service_id');
            $this->services = $event->employee->price->services;
        }
        parent::__construct($config);
    }


    public function servicesList(): array
    {
        return ArrayHelper::map($this->services, 'id', 'name', 'category.parent.name');
    }

    public function rules()
    {
        return [
            ['lists', 'each', 'rule' => ['integer']],
            ['lists', 'default', 'value' => []],
            ['lists', 'required']
        ];
    }

}