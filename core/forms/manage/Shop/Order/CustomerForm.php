<?php


namespace core\forms\manage\Shop\Order;


use core\entities\Shop\Order\Order;
use core\helpers\tHelper;
use yii\base\Model;

class CustomerForm extends Model
{
    public $phone;
    public $name;

    public function __construct(Order $order, array $config = [])
    {
        $this->phone = $order->customerData->phone;
        $this->name = $order->customerData->name;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['phone', 'name'], 'required'],
            [['phone', 'name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('shop/customer','name'),
            'phone' => tHelper::translate('shop/customer','phone'),
        ];
    }
}