<?php


namespace core\forms\manage\Schedule\Event;


use core\entities\Schedule\Event\Event;
use core\helpers\tHelper;
use yii\base\Model;

/**
 * @property ServicesForm $services
 * @property MasterForm $master
 * @property ClientForm $client
 */
class ToolsEditForm extends Model
{
    public $tools;
    private $_event;

    public function __construct(Event $event, $config = [])
    {
        $this->tools = $event->tools;
        $this->_event = $event;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['tools'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tools' => tHelper::translate('schedule/event','Tools'),
        ];
    }
}