<?php


namespace core\entities\Schedule\Additional;


use core\entities\behaviors\MetaBehavior;
use core\entities\Meta;
use core\entities\Schedule\Additional\queries\CategoryQuery;
use core\helpers\tHelper;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;


/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property Meta $meta
 * @property string $meta_json [json]
 * @property Category $parent
 * @property Category[] $children
 * @property Category[] $parents
 * @property Category $prev
 * @property Category $next
 * @mixin NestedSetsBehavior
 */
class Category extends ActiveRecord
{
    public $meta;

    /**
     * @param $name
     * @param $slug
     * @param $title
     * @param $description
     * @param Meta $meta
     * @return static
     */
    public static function create($name, $slug, $title, $description, Meta $meta): self
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->meta = $meta;
        return $category;
    }

    /**
     * @param $name
     * @param $slug
     * @param $title
     * @param $description
     * @param Meta $meta
     */
    public function edit($name, $slug, $title, $description, Meta $meta):void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->title = $title;
        $this->description=$description;
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

    public function attributeLabels()
    {
        return [
            'name'=>tHelper::t('schedule/additional/category','Name'),
            'slug'=>tHelper::t('schedule/additional/category','Slug'),
            'title'=>tHelper::t('schedule/additional/category','Title'),
            'description'=>tHelper::t('schedule/additional/category','Description'),
            'meta.title' => tHelper::translate('meta', 'meta.title'),
            'meta.description' => tHelper::translate('meta', 'meta.description'),
            'meta.keywords' => tHelper::translate('meta', 'meta.keywords'),
        ];
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%schedule_additional_categories}}';
    }

    public function behaviors():array
    {
        return [
            MetaBehavior::class,
            NestedSetsBehavior::class,
        ];
    }

    /**
     * @return array
     */
    public function transactions():array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return CategoryQuery
     */
    public static function find(): CategoryQuery
    {
        return new CategoryQuery(static::class);
    }
}