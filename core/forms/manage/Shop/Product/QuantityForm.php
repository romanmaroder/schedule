<?php


namespace core\forms\manage\Shop\Product;


use core\entities\Shop\Product\Product;
use core\helpers\tHelper;
use yii\base\Model;

class QuantityForm extends Model
{
    public $quantity;

    public function __construct(Product $product = null, $config = [])
    {
        if ($product) {
            $this->quantity = $product->quantity;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['quantity'], 'required'],
            [['quantity'], 'integer', 'min' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'quantity'=>tHelper::translate('shop/product','quantity'),
        ];
    }
}