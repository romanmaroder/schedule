<?php


namespace schedule\entities\Schedule\Product;


use schedule\entities\behaviors\MetaBehavior;
use schedule\entities\Meta;
use schedule\entities\Schedule\Brand;
use schedule\entities\Schedule\Category;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $created_at
 * @property string $code
 * @property string $name
 * @property integer $category_id
 * @property integer $brand_id
 * @property integer $price_old
 * @property integer $price_new
 * @property int $price_intern [int(11)]
 * @property int $price_employee [int(11)]
 * @property integer $rating
 * @property string $meta_json
 *
 * @property Meta $meta
 * @property Brand $brand
 * @property Category $category
 */
class Product extends ActiveRecord
{

    public $meta;


    public static function create($brandId, $categoryId, $code, $name, Meta $meta): self
    {
        $product = new static();
        $product->brand_id = $brandId;
        $product->category_id = $categoryId;
        $product->code = $code;
        $product->name = $name;
        $product->meta = $meta;
        $product->created_at = time();
        return $product;
    }

    /**
     * @param $new
     * @param $old
     * @param $intern
     * @param $employee
     */
    public function setPrice($new, $old, $intern, $employee): void
    {
        $this->price_new = $new;
        $this->price_old = $old;
        $this->price_intern = $intern;
        $this->price_employee = $employee;
    }

    /**
     * @return ActiveQuery
     */
    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brand::class,['id'=>'brand_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class,['id'=>'category_id']);
    }

    public static function tableName(): string
    {
        return '{{%schedule_products}}';
    }

    public function behaviors():array
    {
        return [
            MetaBehavior::class,
        ];
    }
}