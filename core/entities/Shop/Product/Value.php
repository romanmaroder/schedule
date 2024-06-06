<?php


namespace core\entities\Shop\Product;


use core\entities\CommonUses\Characteristic;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $characteristic_id
 * @property string $value
 * @property int $product_id [int(11)]
 *
 * @property Characteristic $characteristic
 */
class Value extends ActiveRecord
{

    /**
     * @param $characteristicId
     * @param $value
     * @return static
     */
    public static function create($characteristicId, $value): self
    {
        $object = new static();
        $object->characteristic_id = $characteristicId;
        $object->value = $value;
        return $object;
    }

    /**
     * @param $characteristicId
     * @return static
     */
    public static function blank($characteristicId): self
    {
        $object = new static();
        $object->characteristic_id = $characteristicId;
        return $object;
    }

    /**
     * @param $id
     * @return bool
     */
    public function isForCharacteristic($id): bool
    {
        return $this->characteristic_id == $id;
    }

    /**
     * @return ActiveQuery
     */
    public function getCharacteristic(): ActiveQuery
    {
        return $this->hasOne(Characteristic::class, ['id' => 'characteristic_id']);
    }

    public function change($value): void
    {
        $this->value = $value;
    }

    public static function tableName(): string
    {
        return '{{%schedule_values}}';
    }
}