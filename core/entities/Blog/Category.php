<?php


namespace core\entities\Blog;


use core\entities\behaviors\MetaBehavior ;
use core\entities\Meta;
use core\helpers\tHelper;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property int $sort
 * @property Meta $meta
 * @property string $meta_json [json]
 */
class Category extends ActiveRecord
{
    public $meta;

    public static function create($name, $slug, $title, $description, $sort, Meta $meta): self
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->sort = $sort;
        $category->meta = $meta;
        return $category;
    }

    public function edit($name, $slug, $title, $description, $sort, Meta $meta): void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->sort = $sort;
        $this->meta = $meta;
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->getHeadingTile();
    }

    public function getHeadingTile(): string
    {
        return $this->title ?: $this->name;
    }

    public function attributeLabels(): array
    {
        return [
            'title' => tHelper::translate('blog/category', 'Title'),
            'name' => tHelper::translate('blog/category', 'Name'),
            'slug' => tHelper::translate('blog/category', 'Slug'),
            'description' => tHelper::translate('blog/category', 'Description'),
            'sort' => tHelper::translate('blog/category', 'Sort'),
            'meta.title' => tHelper::translate('meta', 'meta.title'),
            'meta.description' => tHelper::translate('meta', 'meta.description'),
            'meta.keywords' => tHelper::translate('meta', 'meta.keywords'),
        ];
    }


    public static function tableName(): string
    {
        return '{{%blog_categories}}';
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
        ];
    }
}