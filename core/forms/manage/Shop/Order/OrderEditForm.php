<?php


namespace core\forms\manage\Shop\Order;


use core\entities\Shop\Order\Order;
use core\forms\CompositeForm;

class OrderEditForm extends CompositeForm
{

    public $note;

    public DeliveryForm $delivery;

    public CustomerForm $customer;

    public function __construct(Order $order, array $config = [])
    {
        $this->note = $order->note;
        $this->delivery = new DeliveryForm($order);
        $this->customer = new CustomerForm($order);
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