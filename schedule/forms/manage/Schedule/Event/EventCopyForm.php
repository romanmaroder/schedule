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
        $clone = $event->copied();

        $this->master = new MasterForm($clone);
        $this->client = new ClientForm($clone);
        $this->notice = $clone->notice;
        $this->start = $clone->start;
        $this->end = $clone->end;
        $this->discount = $clone->discount;
        $this->discount_from = $clone->discount_from;
        $this->status = $clone->status;
        $this->payment = $clone->payment;
        $this->amount = $clone->amount;
        $this->services = new ServicesForm($clone);
        $this->_event = $clone;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['discount_from','status','amount','payment'], 'integer'],
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