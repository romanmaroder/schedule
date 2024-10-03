<?php


namespace core\entities\CommonUses;


use core\entities\behaviors\MetaBehavior;
use core\entities\Meta;
use core\helpers\tHelper;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $meta_json [json]
 * @property Meta $meta
 */
class Brand extends ActiveRecord
{
    public $meta;

    /**
     * @param $name
     * @param $slug
     * @param Meta $meta
     * @return static
     */
    public static function create($name, $slug, Meta $meta): self
    {
        $brand = new static();
        $brand->name = $name;
        $brand->slug = $slug;
        $brand->meta = $meta;
        return $brand;
    }

    /**
     * @param $name
     * @param $slug
     * @param Meta $meta
     */
    public function edit($name, $slug, Meta $meta): void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->meta = $meta;
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->name;
    }

    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('shop/brand','name'),
            'slug' => tHelper::translate('shop/brand','slug'),
            'meta.title' => tHelper::translate('meta','Title'),
            'meta.description' => tHelper::translate('meta','Description'),
            'meta.keywords' => tHelper::translate('meta','Keywords'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%shop_brands}}';
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
        ];
    }

}