<?php


namespace core\entities\Blog;


use core\helpers\tHelper;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 */
class Tag extends ActiveRecord
{
    public static function create($name, $slug): self
    {
        $tag = new static();
        $tag->name = $name;
        $tag->slug = $slug;
        return $tag;
    }

    public function edit($name, $slug): void
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('blog/tag', 'Name'),
            'slug' => tHelper::translate('blog/tag', 'Slug'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%blog_tags}}';
    }
}