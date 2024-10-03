<?php


namespace core\forms\manage\Blog;


use core\entities\Blog\Category;
use core\forms\CompositeForm;
use core\forms\manage\MetaForm;
use core\helpers\tHelper;
use core\validators\SlugValidator;

/**
 * @property MetaForm $meta;
 */
class CategoryForm extends CompositeForm
{

    public $name;
    public $slug;
    public $title;
    public $description;
    public $sort;

    private $_category;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->sort = $category->sort;
            $this->meta = new MetaForm($category->meta);
            $this->_category = $category;
        } else {
            $this->meta = new MetaForm();
            $this->sort = Category::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null]
        ];
    }
    public function attributeLabels()
    {
        return [
            'title' => tHelper::translate('blog/category', 'Title'),
            'name' => tHelper::translate('blog/category', 'Name'),
            'slug' => tHelper::translate('blog/category', 'Slug'),
            'description' => tHelper::translate('blog/category', 'Description'),
            'sort' => tHelper::translate('blog/category', 'Sort'),
        ];
    }

    public function internalForms(): array
    {
        return ['meta'];
    }
}