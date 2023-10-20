<?php


namespace schedule\forms\manage\Schedule\Product;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoriesForm extends Model
{
    public $main;
    public $other=[];

    /**
     * CategoriesForm constructor.
     * @param Product $product
     * @param array $config
     */
    public function __construct(Product $product, $config = [])
    {
        if ($product){
            $this->main = $product->categorry_id;
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