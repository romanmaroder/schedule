<?php


namespace core\entities\Schedule\Product;


use yii\db\ActiveRecord;

/**
 * Class CategoryAssignments
 * @package core\entities\core\Product
 *
 * @property int $product_id [int(11)]
 * @property int $category_id [int(11)]
 */
class CategoryAssignment extends ActiveRecord
{

    public static function create($categoryId): self
    {
        $assignment = new static();
        $assignment->category_id = $categoryId;
        return $assignment;
    }

    /**
     * @param $id
     * @return bool
     */
    public function isForCategory($id): bool
    {
        return $this->category_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%schedule_category_assignments}}';
    }
}