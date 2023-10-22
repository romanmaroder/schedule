<?php


namespace schedule\entities\Schedule\Product;


use yii\db\ActiveRecord;

/**
 * @property int $product_id;
 * @property int $tag_id;
 * @property int $service_id [int(11)]
 */
class TagAssignment extends ActiveRecord
{
    public static function create($tagId): self
    {
        $assignment = new static();
        $assignment->tag_id = $tagId;
        return $assignment;
    }

    public function isForTag($id): bool
    {
        return $this->tag_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%schedule_tag_assignments}}';
    }
}