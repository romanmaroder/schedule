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
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 * @property TagsForm $tags
 * @property ValueForm[] $values
 */
class ProductEditForm extends CompositeForm
{
    public $brandId;
    public $code;
    public $name;
    public $description;
    public $weight;

    private $_product;

    public function __construct(Product $product, $config = [])
    {
        $this->brandId = $product->brand_id;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->weight = $product->weight;
        $this->meta = new MetaForm($product->meta);
        $this->categories= new CategoriesForm($product);
        $this->tags = new TagsForm($product);
        $this->values = array_map(function (Characteristic $characteristic) use ($product) {
            return new ValueForm($characteristic, $product->getValue($characteristic->id));
        }, Characteristic::find()->orderBy('sort')->all());
        $this->_product = $product;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['brandId', 'code', 'name','weight'], 'required'],
            [['brandId'], 'integer'],
            [['code', 'name'], 'string', 'max' => 255],
            [
                ['code'],
                'unique',
                'targetClass' => Product::class,
                'filter' => $this->_product ? ['<>', 'id', $this->_product->id] : null
            ],
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
        return ['meta','categories', 'tags', 'values'];
    }
}