<?php


namespace schedule\forms\manage\Expenses;


use schedule\entities\Expenses\Category;
use schedule\forms\CompositeForm;
use schedule\forms\manage\MetaForm;
use schedule\validators\SlugValidator;
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