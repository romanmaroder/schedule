<?php


namespace core\forms\manage\Schedule\Event;


use core\forms\CompositeForm;
use core\helpers\tHelper;

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
    public $discount;
    public $discount_from;
    public $status;
    public $payment;
    public $amount;
    public $rate;
    public $fullname;
    public $tools;


    public function __construct($config = [])
    {
        $this->services = new ServicesForm();
        $this->master = new MasterForm();
        $this->client = new ClientForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['discount_from', 'status', 'amount', 'payment'], 'integer'],
            [['start', 'end'], 'required'],
            ['notice', 'string'],
            [['amount', 'payment', 'rate', 'fullname', 'tools'], 'safe'],
            ['discount', 'required', 'when' => function ($model) {
                return $model->discount_from > 0;
            }, 'whenClient' => "function (attribute, value) {
                return $('#discountFrom').val() != 0;
            }"
            ],
            [['discount'], 'integer', 'max' => 100, 'min' => 0],
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
        ];
    }


    protected function internalForms(): array
    {
        return ['services', 'master', 'client'];
    }
}