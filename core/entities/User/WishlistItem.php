<?php


namespace core\entities\User;


use yii\db\ActiveRecord;

/**
 * @property int $user_id
 * @property int $product_id
 */
class WishlistItem extends ActiveRecord
{
    public static function create($productId)
    {
        $item = new static();
        $item->product_id = $productId;
        return $item;
    }

    public function isForProduct($productId): bool
    {
        return $this->product_id == $productId;
    }

    public static function tableName(): string
    {
        return '{{%user_wishlist_items}}';
    }
}