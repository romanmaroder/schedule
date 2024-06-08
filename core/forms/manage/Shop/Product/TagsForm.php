<?php


namespace core\forms\manage\Shop\Product;


use core\entities\Shop\Product\Product;
use core\entities\Shop\Product\Tag;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property array $newNames
 */
class TagsForm extends Model
{
    public $existing = [];
    public $textNew;

    /**
     * TagsForm constructor.
     * @param Product|null $product
     * @param array $config
     */
    public function __construct(Product $product=null, $config = [])
    {
        if ($product) {
            $this->existing = ArrayHelper::getColumn($product->tagAssignments, 'tag_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['existing', 'each', 'rule' => ['integer']],
            ['existing', 'default', 'value' => []],
            ['textNew', 'string'],
        ];
    }

    public function tagsList(): array
    {
        return ArrayHelper::map(Tag::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    public function getNewNames(): array
    {
        return array_filter(array_map('trim', preg_split('#\s,\s*#i', $this->textNew)));
    }
}