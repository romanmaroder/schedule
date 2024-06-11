<?php


namespace core\forms\Shop\Order;


use core\forms\CompositeForm;

class OrderForm extends CompositeForm
{

    public $note;

    public function __construct(int $weight, array $config = [])
    {
        $this->delivery = new DeliveryForm($weight);
        $this->customer = new CustomerForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['note'], 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return ['delivery', 'customer'];
    }
}