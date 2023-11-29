<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\forms\CompositeForm;

/**
 * @property ServicesForm $services
 * @property MasterForm $master
 * @property ClientForm $client
 */
class EventCreateForm extends CompositeForm
{
    public $notice;
    public $start;
    public $end;

    public function __construct($config = [])
    {
        $this->services = new ServicesForm();
        $this->master = new MasterForm();
        $this->client = new ClientForm();
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