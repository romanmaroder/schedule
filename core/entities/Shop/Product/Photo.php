<?php


namespace core\entities\Shop\Product;


use romanmaroder\upload\ImageUploadBehavior;
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
        return '{{%shop_photos}}';
    }
    public function behaviors():array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'cart_list' => ['width' => 50, 'height' => 50],
                    //'cart_widget_list' => ['width' => 57, 'height' => 57],
                    //'catalog_list' => ['width' => 228, 'height' => 228],
                    'catalog_product_main' => ['width' => 500, 'height' => 500],
                    'catalog_product_additional' => ['width' => 66, 'height' => 66],
                ],
            ],
        ];
    }
}