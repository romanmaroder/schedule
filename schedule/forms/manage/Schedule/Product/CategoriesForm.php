<?php


namespace schedule\forms\manage\Schedule\Product;


use schedule\entities\Schedule\Product\Product;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoriesForm extends Model
{
    public $main;
    public $other=[];

    /**
     * CategoriesForm constructor.
     * @param Product|null $product
     * @param array $config
     */
    public function __construct(Product $product=null, $config = [])
    {
        if ($product){
            $this->main = $product->category_id;
            $this->other = ArrayHelper::getColumn($product->categoryAssignments,'category_id');
        }
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            ['main','required'],
            ['main','integer'],
            ['other','each','rule'=>['integer']],
            ['other','default','value' => []],
        ];
    }
}