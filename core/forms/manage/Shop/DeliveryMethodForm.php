<?php


namespace core\forms\manage\Shop;


use core\entities\Shop\DeliveryMethod;
use core\helpers\tHelper;
use yii\base\Model;

class DeliveryMethodForm extends Model
{
    public $name;
    public $cost;
    public $minWeight;
    public $maxWeight;
    public $sort;

    public function __construct(DeliveryMethod $method = null, $config = [])
    {
        if ($method) {
            $this->name = $method->name;
            $this->cost = $method->cost;
            $this->minWeight = $method->min_weight;
            $this->maxWeight = $method->max_weight;
            $this->sort = $method->sort;
        } else {
            $this->sort = DeliveryMethod::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'cost', 'sort'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['cost', 'minWeight', 'maxWeight', 'sort'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('shop/delivery','name'),
            'cost' => tHelper::translate('shop/delivery','cost'),
            'minWeight' => tHelper::translate('shop/delivery','min_weight'),
            'maxWeight' => tHelper::translate('shop/delivery','max_weight'),
            'sort' => tHelper::translate('shop/delivery','sort'),
        ];
    }

}