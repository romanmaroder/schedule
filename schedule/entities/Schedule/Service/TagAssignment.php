<?php


namespace schedule\entities\Schedule\Service;


use yii\db\ActiveRecord;

/**
 * @property integer $service_id;
 * @property integer $tag_id;
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