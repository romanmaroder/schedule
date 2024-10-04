<?php


namespace core\forms\manage\Shop\Product;


use core\entities\Shop\Product\Product;
use core\forms\manage\MetaForm;
use core\helpers\tHelper;
use yii\base\Model;

/**
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 * @property TagsForm $tags
 * @property ValueForm[] $values
 */
class PriceForm extends Model
{
    public $old;
    public $new;

    /**n
     *
     * PriceForm constructor.
     * @param Product|null $product
     * @param array $config
     */
    public function __construct(Product $product = null, $config = [])
    {
        if ($product){
            $this->new = $product->price_new;
            $this->old = $product->price_old;
        }
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['new'],'required'],
            [['new','old'],'integer','min' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'old'=>tHelper::translate('shop/product','price_old'),
            'new'=>tHelper::translate('shop/product','price_new'),
        ];
    }
}