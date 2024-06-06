<?php


namespace core\entities\Shop\Product;


use yii\db\ActiveRecord;

/**
 * @property int $product_id;
 * @property int $related_id
 */
class RelatedAssignment extends ActiveRecord
{

    /**
     * @param $productId
     * @return static
     */
    public static function create($productId): self
    {
        $assignment = new static();
        $assignment->related_id = $productId;
        return $assignment;
    }

    public function isForProduct($id): bool
    {
        return $this->related_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%schedule_related_assignments}}';
    }
}