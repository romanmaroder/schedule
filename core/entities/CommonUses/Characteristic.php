<?php


namespace core\entities\CommonUses;


use core\entities\Enums\CharacteristicEnum;
use core\helpers\tHelper;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $required
 * @property string $default
 * @property array $variants
 * @property int $sort
 * @property string $variants_json [json]
 */
class Characteristic extends ActiveRecord
{
    public $variants;

    /**
     * @param $name
     * @param $type
     * @param $required
     * @param $default
     * @param array $variants
     * @param $sort
     * @return static
     */
    public static function create($name, $type, $required, $default, array $variants, $sort): self
    {
        $object = new static();
        $object->name = $name;
        $object->type = $type;
        $object->required = $required;
        $object->default = $default;
        $object->variants = $variants;
        $object->sort = $sort;
        return $object;
    }

    /**
     * @param $name
     * @param $type
     * @param $required
     * @param $default
     * @param array $variants
     * @param $sort
     */
    public function edit($name, $type, $required, $default, array $variants, $sort): void
    {
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
        $this->default = $default;
        $this->variants = $variants;
        $this->sort = $sort;
    }

    /**
     * @return bool
     */
    public function isString(): bool
    {
        return $this->type == CharacteristicEnum::TYPE_STRING->value;
    }

    /**
     * @return bool
     */
    public function isInteger(): bool
    {
        return $this->type == CharacteristicEnum::TYPE_INTEGER->value;
    }

    /**
     * @return bool
     */
    public function isFloat(): bool
    {
        return $this->type == CharacteristicEnum::TYPE_FLOAT->value;
    }

    /**
     * @return bool
     */
    public function isSelect(): bool
    {
        return count($this->variants) > 0;
    }

    public function attributeLabels(): array
    {
        return [
            'name' => tHelper::translate('shop/characteristic', 'name'),
            'type' => tHelper::translate('shop/characteristic', 'type'),
            'required' => tHelper::translate('shop/characteristic', 'required'),
            'default' => tHelper::translate('shop/characteristic', 'default'),
            'variants' => tHelper::translate('shop/characteristic', 'variants'),
            'sort' => tHelper::translate('shop/characteristic', 'sort'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%shop_characteristics}}';
    }

    public function afterFind(): void
    {
        $this->variants = array_filter(Json::decode($this->getAttribute('variants_json')));
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('variants_json', Json::encode(array_filter($this->variants)));
        return parent::beforeSave($insert);
    }

}