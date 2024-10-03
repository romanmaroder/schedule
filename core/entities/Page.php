<?php


namespace core\entities;

use core\helpers\tHelper;
use paulzi\nestedsets\NestedSetsBehavior;
use core\entities\behaviors\MetaBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property Meta $meta
 *
 * @property Page $parent
 * @property Page[] $parents
 * @property Page[] $children
 * @property Page $prev
 * @property Page $next
 * @property string $meta_json [json]
 * @mixin NestedSetsBehavior
 */
class Page extends ActiveRecord
{
    public $meta;

    public static function create($title, $slug, $content, Meta $meta): self
    {
        $category = new static();
        $category->title = $title;
        $category->slug = $slug;
        $category->title = $title;
        $category->content = $content;
        $category->meta = $meta;
        return $category;
    }

    public function edit($title, $slug, $content, Meta $meta): void
    {
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $content;
        $this->meta = $meta;
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->title;
    }

    public function attributeLabels()
    {
        return [
            'title' => tHelper::translate('content/page','title'),
            'slug' => tHelper::translate('content/page','slug'),
            'content' => tHelper::translate('content/page','content'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%pages}}';
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
            NestedSetsBehavior::class,
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
}