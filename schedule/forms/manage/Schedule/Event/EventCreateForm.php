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
    public $discount;
    public $discount_from;
    public $status;


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
            [['discount_from','status'], 'integer'],
            [['start', 'end'], 'required'],
            ['notice', 'string'],
            ['discount', 'required', 'when' => function($model) {
                return $model->discount_from > 0;
            },'whenClient' => "function (attribute, value) {
                return $('#discountFrom').val() != 0;
            }"
            ],
            [['discount'], 'integer','max' => 100,'min'=>0],
        ];
    }

    protected function internalForms(): array
    {
        return ['services','master','client'];
    }
}