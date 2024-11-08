<?php


namespace core\forms\manage\Shop;


use core\entities\Shop\Product\Category;
use core\forms\CompositeForm;
use core\forms\manage\MetaForm;
use core\helpers\tHelper;
use core\validators\SlugValidator;
use yii\helpers\ArrayHelper;

/**
 * @property MetaForm $meta;
 */
class CategoryForm extends CompositeForm
{
    public $name;
    public $slug;
    public $title;
    public $description;
    public $parentId;

    private $_category;


    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->parentId = $category->parent ? $category->parent->id : null;
            $this->meta = new MetaForm($category->meta);
            $this->_category = $category;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['name', 'slug'], 'required'],
            [['parentId'], 'integer'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['slug', SlugValidator::class],
            [
                ['name', 'slug'],
                'unique',
                'targetClass' => Category::class,
                'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => tHelper::translate('shop/category', 'Title'),
            'name' => tHelper::translate('shop/category', 'Name'),
            'slug' => tHelper::translate('shop/category', 'Slug'),
            'description' => tHelper::translate('shop/category', 'Description'),
            'sort' => tHelper::translate('shop/category', 'Sort'),
            'parentId' => tHelper::translate('shop/category', 'Parent Id'),
        ];
    }

    /**
     * @return array
     */
    public function parentCategoriesList(): array
    {
        return ArrayHelper::map(
            Category::find()->orderBy('lft')->asArray()->all(),
            'id',
            function (array $category) {
                return ($category['depth'] > 1 ? str_repeat(
                            '-- ',
                            $category['depth'] - 1
                        ) . ' ' : '') . $category['name'];
            }
        );
    }

    protected function internalForms(): array
    {
        return ['meta'];
    }
}