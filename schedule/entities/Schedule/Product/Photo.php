<?php


namespace schedule\entities\Schedule\Product;


use yii\db\ActiveRecord;
use yii\web\UploadedFile;


/**
 * @property int $id
 * @property string $file
 * @property int $sort
 * @property int $product_id [int(11)]
 */
class Photo extends ActiveRecord
{
    /**
     * @param UploadedFile $file
     * @return static
     */
    public static function create(UploadedFile $file): self
    {
        $photo = new static();
        $photo->file = $file;
        return $photo;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName(): string
    {
        return '{{%schedule_photos}}';
    }
}