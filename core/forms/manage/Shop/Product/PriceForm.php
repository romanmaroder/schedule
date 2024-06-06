<?php


namespace core\forms\manage\Shop\Product;


use core\entities\Shop\Product\Product;
use core\forms\manage\MetaForm;
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
    public $intern;
    public $employee;

    /**n
     *
     * PriceForm constructor.
     * @param \core\entities\Shop\Product\Product|null $product
     * @param array $config
     */
    public function __construct(Product $product = null, $config = [])
    {
        if ($product){
            $this->new = $product->price_new;
            $this->old = $product->price_old;
            $this->intern = $product->price_intern;
            $this->employee = $product->price_employee;
        }
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['new'],'required'],
            [['new','old','intern','employee'],'integer','min' => 0],
        ];
    }
}