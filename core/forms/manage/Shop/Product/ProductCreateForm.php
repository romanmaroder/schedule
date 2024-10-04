<?php


namespace core\forms\manage\Shop\Product;


use core\entities\CommonUses\Brand;
use core\entities\CommonUses\Characteristic;
use core\entities\Shop\Product\Product;
use core\forms\CompositeForm;
use core\forms\manage\MetaForm;
use core\helpers\tHelper;
use yii\helpers\ArrayHelper;

/**
 * @property PriceForm $price
 * @property QuantityForm $quantity
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 * @property PhotosForm $photos
 * @property TagsForm $tags
 * @property ValueForm[] $values
 */
class ProductCreateForm extends CompositeForm
{
    public $brandId;
    public $code;
    public $name;
    public $description;
    public $weight;

    public function __construct($config = [])
    {
        $this->price = new PriceForm();
        $this->quantity = new QuantityForm();
        $this->meta = new MetaForm();
        $this->categories = new CategoriesForm();
        $this->photos = new PhotosForm();
        $this->tags = new TagsForm();
        $this->values = array_map(function (Characteristic $characteristic) {
            return new ValueForm($characteristic);
        }, Characteristic::find()->orderBy('sort')->all());
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['brandId', 'code', 'name','weight'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            [['brandId'], 'integer'],
            [['code'], 'unique', 'targetClass' => Product::class],
            ['description', 'string'],
            ['weight', 'integer', 'min' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code'=>tHelper::translate('shop/product','code'),
            'name'=>tHelper::translate('shop/product','name'),
            'weight'=>tHelper::translate('shop/product','weight'),
            'description'=>tHelper::translate('shop/product','description'),
            'brandId'=>tHelper::translate('shop/product','brand_id'),

        ];
    }

    public function brandsList(): array
    {
        return ArrayHelper::map(Brand::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    protected function internalForms(): array
    {
        return ['price','quantity', 'meta', 'photos', 'categories', 'tags', 'values'];
    }

}
