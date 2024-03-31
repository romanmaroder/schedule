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
    public $discount;
    public $discount_from;
    public $status;
    public $amount;
    private $_event;

    public function __construct(Event $event, $config = [])
    {
        $this->master = new MasterForm($event);
        $this->client = new ClientForm($event);
        $this->notice = $event->notice;
        $this->start = $event->start;
        $this->end = $event->end;
        $this->discount = $event->discount;
        $this->discount_from = $event->discount_from;
        $this->status = $event->status;
        $this->amount = $event->amount;
        $this->services = new ServicesForm($event);
        $this->_event = $event;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['discount_from','status','amount'], 'integer'],
            [['start', 'end'], 'required'],
            ['notice', 'string'],
            ['discount', 'required', 'when' => function($model) {
                return $model->discount_from > 0;
            },'whenClient' => "function (attribute, value) {
                return $('#discountFrom').val() != 0;
            }"
            ],
            [['discount'], 'integer','max' => 100,'min'=>0],
            [['amount'],'safe']
        ];
    }

    protected function internalForms(): array
    {
        return ['services','master','client'];
    }
}