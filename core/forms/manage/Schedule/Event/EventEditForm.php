<?php


namespace core\forms\manage\Schedule\Event;


use core\entities\Schedule\Event\Event;
use core\forms\CompositeForm;
use core\helpers\tHelper;

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
    public $payment;
    public $amount;
    public $rate;
    public $fullname;
    public $tools;
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
        $this->payment = $event->payment;
        $this->amount = $event->amount;
        $this->rate = $event->rate;
        $this->fullname = $event->fullname;
        $this->tools = $event->tools;
        $this->services = new ServicesForm($event);
        $this->_event = $event;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['discount_from','status','amount','payment','tools'], 'integer'],
            [['start', 'end'], 'required'], [[], 'safe'],
            ['notice', 'string'],
            ['discount', 'required', 'when' => function($model) {
                return $model->discount_from > 0;
            },'whenClient' => "function (attribute, value) {
                return $('#discountFrom').val() != 0;
            }"
            ],
            [['discount'], 'integer','max' => 100,'min'=>0],
            [['amount','payment','rate','fullname'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'discount' => tHelper::translate('schedule/event', 'Discount'),
            'discount_from' => tHelper::translate('schedule/event', 'Discount From'),
            'start' => tHelper::translate('schedule/event', 'Start'),
            'end' => tHelper::translate('schedule/event', 'End'),
            'status' => tHelper::translate('schedule/event', 'Status'),
            'payment' => tHelper::translate('schedule/event', 'Payment'),
            'cost' => tHelper::translate('schedule/event', 'Cost'),
            'notice' => tHelper::translate('schedule/event', 'Notice'),
            'tools' => tHelper::translate('schedule/event','Tools'),
        ];
    }

    protected function internalForms(): array
    {
        return ['services','master','client'];
    }
}