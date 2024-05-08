<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\entities\Schedule\Event\Event;
use schedule\forms\CompositeForm;

/**
 * @property ServicesForm $services
 * @property MasterForm $master
 * @property ClientForm $client
 */
class EventCopyForm extends CompositeForm
{
    public $id;
    public $notice;
    public $start;
    public $end;
    public $discount;
    public $discount_from;
    public $status;
    public $payment;
    public $amount;
    private $_event;

    public function __construct(Event $event, $config = [])
    {
        $this->id = $event->lastId()->id +1;
        $this->master = new MasterForm($event);
        $this->client = new ClientForm($event);
        $this->notice = $event->notice;
        $this->start = $event->start;
        $this->end = $event->end;
        $this->discount = $event->discount;
        $this->discount_from = $event->discount_from;
        $this->status = $event->status;
        $this->payment = $event->payment;
        $this->amount = $event->amount;
        $this->services = new ServicesForm($event);
        $this->_event = $event;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['id','discount_from','status','amount','payment'], 'integer'],
            [['start', 'end'], 'required'],
            ['notice', 'string'],
            ['discount', 'required', 'when' => function($model) {
                return $model->discount_from > 0;
            },'whenClient' => "function (attribute, value) {
                return $('#discountFrom').val() != 0;
            }"
            ],
            [['discount'], 'integer','max' => 100,'min'=>0],
            [['amount','payment'],'safe']
        ];
    }

    protected function internalForms(): array
    {
        return ['services','master','client'];
    }
}