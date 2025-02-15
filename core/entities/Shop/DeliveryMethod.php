<?php


namespace core\entities\Shop;


use core\entities\Shop\queries\DeliveryMethodQuery;
use core\helpers\tHelper;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int $cost
 * @property int $min_weight
 * @property int $max_weight
 * @property int $sort
 */
class DeliveryMethod extends ActiveRecord
{
    public static function create($name, $cost, $minWeight, $maxWeight, $sort): self
    {
        $method = new static();
        $method->name = $name;
        $method->cost = $cost;
        $method->min_weight = $minWeight;
        $method->max_weight = $maxWeight;
        $method->sort = $sort;
        return $method;
    }

    public function edit($name, $cost, $minWeight, $maxWeight, $sort): void
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->min_weight = $minWeight;
        $this->max_weight = $maxWeight;
        $this->sort = $sort;
    }

    public function isAvailableForWeight($weight): bool
    {
        return (!$this->min_weight || $this->min_weight <= $weight) && (!$this->max_weight || $weight <= $this->max_weight);
    }

    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('shop/delivery','name'),
            'cost' => tHelper::translate('shop/delivery','cost'),
            'min_weight' => tHelper::translate('shop/delivery','min_weight'),
            'max_weight' => tHelper::translate('shop/delivery','max_weight'),
            'sort' => tHelper::translate('shop/delivery','sort'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%shop_delivery_methods}}';
    }

    public static function find(): DeliveryMethodQuery
    {
        return new DeliveryMethodQuery(static::class);
    }
}