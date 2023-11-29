<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\entities\Schedule\Event\Event;
use schedule\forms\CompositeForm;

/**
 * @property ServicesForm $services
 * @property MasterForm $master
 * @property ClientForm $client
 */
class EventEditForm extends CompositeForm
{

    public $notice;
    public $start;
    public $end;

    private $_event;

    public function __construct(Event $event, $config = [])
    {
        $this->master = new MasterForm($event);
        $this->client = new ClientForm($event);
        $this->notice = $event->notice;
        $this->start = $event->start;
        $this->end = $event->end;
        $this->services = new ServicesForm($event);
        $this->_event = $event;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['start', 'end'], 'required'],
            ['notice', 'string']
        ];
    }

    protected function internalForms(): array
    {
        return ['services','master','client'];
    }
}