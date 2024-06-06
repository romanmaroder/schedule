<?php


namespace core\entities\CommonUses;


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
    public static function create($name, $slug): \core\entities\Shop\Product\self
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

    public static function tableName():string
    {
        return '{{%shop_tags}}';
    }
}