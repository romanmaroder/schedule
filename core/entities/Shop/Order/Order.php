<?php


namespace core\entities\Shop\Order;


use core\entities\Enums\StatusOrderEnum;
use core\entities\Shop\DeliveryMethod;
use core\entities\User\User;
use core\helpers\tHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * @property int $id
 * @property int $created_at
 * @property int $user_id
 * @property int $delivery_method_id
 * @property string $delivery_method_name
 * @property int $delivery_cost
 * @property string $payment_method
 * @property int $cost
 * @property int $note
 * @property int $current_status
 * @property string $cancel_reason
 * @property CustomerData $customerData
 * @property DeliveryData $deliveryData
 *
 * @property OrderItem[] $items
 * @property Status[] $statuses
 * @property string $statuses_json [json]
 * @property string $customer_phone [varchar(255)]
 * @property string $customer_name [varchar(255)]
 * @property string $delivery_index [varchar(255)]
 * @property string $delivery_address
 */
class Order extends ActiveRecord
{
    public $customerData;
    public $deliveryData;
    public $statuses = [];

    public static function create($userId, CustomerData $customerData, array $items, $cost, $note): self
    {
        $order = new static();
        $order->user_id = $userId;
        $order->customerData = $customerData;
        $order->items = $items;
        $order->cost = $cost;
        $order->note = $note;
        $order->created_at = time();
        $order->addStatus(StatusOrderEnum::NEW->value);
        return $order;
    }

    public function edit(CustomerData $customerData, $note): void
    {
        $this->customerData = $customerData;
        $this->note = $note;
    }

    public function setDeliveryInfo(DeliveryMethod $method, DeliveryData $deliveryData): void
    {
        $this->delivery_method_id = $method->id;
        $this->delivery_method_name = $method->name;
        $this->delivery_cost = $method->cost;
        $this->deliveryData = $deliveryData;
    }

    public function pay($method): void
    {
        if ($this->isPaid()) {
            throw new \DomainException('Order is already paid.');
        }
        $this->payment_method = $method;
        $this->addStatus(StatusOrderEnum::PAID);
    }

    public function send(): void
    {
        if ($this->isSent()) {
            throw new \DomainException('Order is already sent.');
        }
        $this->addStatus(StatusOrderEnum::SENT);
    }

    public function complete(): void
    {
        if ($this->isCompleted()) {
            throw new \DomainException('Order is already completed.');
        }
        $this->addStatus(StatusOrderEnum::COMPLETED);
    }

    public function cancel($reason): void
    {
        if ($this->isCancelled()) {
            throw new \DomainException('Order is already cancelled.');
        }
        $this->cancel_reason = $reason;
        $this->addStatus(StatusOrderEnum::CANCELLED);
    }

    public function getTotalCost(): int
    {
        return $this->cost + $this->delivery_cost;
    }

    public function canBePaid(): bool
    {
        return $this->isNew();
    }

    public function isNew(): bool
    {
        return $this->current_status == StatusOrderEnum::NEW->value;
    }

    public function isPaid(): bool
    {
        return $this->current_status == StatusOrderEnum::PAID->value;
    }

    public function isSent(): bool
    {
        return $this->current_status == StatusOrderEnum::SENT->value;
    }

    public function isCompleted(): bool
    {
        return $this->current_status == StatusOrderEnum::COMPLETED->value;
    }

    public function isCancelled(): bool
    {
        return $this->current_status == StatusOrderEnum::CANCELLED->value;
    }

    private function addStatus($value): void
    {
        $this->statuses[] = new Status($value, time());
        $this->current_status = $value;
    }

    ##########################

    public function getUser(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id']);
    }

    public function getDeliveryMethod(): ActiveQuery
    {
        return $this->hasMany(DeliveryMethod::class, ['id' => 'delivery_method_id']);
    }

    public function getItems(): ActiveQuery
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    ##########################

    public function attributeLabels(): array
    {
        return [
            'user_id'=>tHelper::translate('shop/order','user_id'),
            'delivery_method_id'=>tHelper::translate('shop/order','delivery_method_id'),
            'delivery_method_name'=>tHelper::translate('shop/order','delivery_method_name'),
            'delivery_index'=>tHelper::translate('shop/order','delivery_index'),
            'delivery_address'=>tHelper::translate('shop/order','delivery_address'),
            'delivery_cost'=>tHelper::translate('shop/order','delivery_cost'),
            'deliveryData.index'=>tHelper::translate('shop/order','delivery_index'),
            'deliveryData.address'=>tHelper::translate('shop/order','delivery_address'),
            'payment_method'=>tHelper::translate('shop/order','payment_method'),
            'cost'=>tHelper::translate('shop/order','cost'),
            'status'=>tHelper::translate('shop/order','status'),
            'note'=>tHelper::translate('shop/order','note'),
            'current_status'=>tHelper::translate('shop/order','current_status'),
            'customer_phone'=>tHelper::translate('shop/order','customer_phone'),
            'customer_name'=>tHelper::translate('shop/order','customer_name'),
            'created_at'=>tHelper::translate('shop/order','created_at'),
            'total_cost'=>tHelper::translate('shop/order','total_cost'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%shop_orders}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['items'],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterFind(): void
    {
        $this->statuses = array_map(function ($row) {
            return new Status(
                $row['value'],
                $row['created_at']
            );
        }, Json::decode($this->getAttribute('statuses_json')));

        $this->customerData = new CustomerData(
            $this->getAttribute('customer_phone'),
            $this->getAttribute('customer_name')
        );

        $this->deliveryData = new DeliveryData(
            $this->getAttribute('delivery_index'),
            $this->getAttribute('delivery_address')
        );

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('statuses_json', Json::encode(array_map(function (Status $status) {
            return [
                'value' => $status->value,
                'created_at' => $status->created_at,
            ];
        }, $this->statuses)));

        $this->setAttribute('customer_phone', $this->customerData->phone);
        $this->setAttribute('customer_name', $this->customerData->name);

        $this->setAttribute('delivery_index', $this->deliveryData->index);
        $this->setAttribute('delivery_address', $this->deliveryData->address);

        return parent::beforeSave($insert);
    }
}