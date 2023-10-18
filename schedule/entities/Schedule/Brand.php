<?php


namespace schedule\entities\Schedule;


use schedule\entities\behaviors\MetaBehavior;
use schedule\entities\Meta;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
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

    public static function tableName(): string
    {
        return '{{%schedule_brands}}';
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
        ];
    }

}