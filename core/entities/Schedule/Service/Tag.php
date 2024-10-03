<?php


namespace core\entities\Schedule\Service;


use core\helpers\tHelper;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 */
class Tag extends ActiveRecord
{


    /**
     * @param $name
     * @param $slug
     * @return static
     */
    public static function create($name, $slug): self
    {
        $tag = new static();
        $tag->name = $name;
        $tag->slug = $slug;
        return $tag;
    }

    /**
     * @param $name
     * @param $slug
     */
    public function edit($name, $slug): void
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('schedule/service/tag', 'Name'),
            'slug' => tHelper::translate('schedule/service/tag', 'Slug'),
            'meta.title' => tHelper::translate('meta', 'Title'),
            'meta.description' => tHelper::translate('meta', 'Description'),
            'meta.keywords' => tHelper::translate('meta', 'Keywords'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%schedule_service_tags}}';
    }
}