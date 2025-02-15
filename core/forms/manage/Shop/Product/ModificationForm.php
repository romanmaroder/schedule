<?php


namespace core\forms\manage\Shop\Product;


use core\entities\Shop\Product\Modification;
use core\helpers\tHelper;
use yii\base\Model;

class ModificationForm extends Model
{
    public $code;
    public $name;
    public $price;
    public $quantity;

    /**
     * ModificationForm constructor.
     * @param Modification|null $modification
     * @param array $config
     */
    public function __construct(Modification $modification = null, $config = [])
    {
        if ($modification) {
            $this->code = $modification->code;
            $this->name = $modification->name;
            $this->price = $modification->price;
            $this->quantity = $modification->quantity;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['code', 'name','quantity'], 'required'],
            [['price'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code'=>tHelper::translate('shop/product','code'),
            'name'=>tHelper::translate('shop/product','name'),
            'quantity'=>tHelper::translate('shop/product','quantity'),
            'price'=>tHelper::translate('shop/product','price'),

        ];
    }

}