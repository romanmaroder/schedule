<?php


namespace core\entities\Shop\Product;


use core\entities\User\User;
use core\helpers\tHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $created_at
 * @property int $user_id
 * @property int $vote
 * @property string $text
 * @property bool $active
 * @property int $product_id [int(11)]
 * @property User $user
 * @property Product $product
 */
class Review extends ActiveRecord
{
    public static function create($userId, int $vote, string $text): self
    {
        $review = new static();
        $review->user_id = $userId;
        $review->vote = $vote;
        $review->text = $text;
        $review->created_at = time();
        $review->active = true;
        return $review;
    }

    public function edit($vote, $text): void
    {
        $this->vote = $vote;
        $this->text = $text;
    }

    public function activate(): void
    {
        $this->active = true;
    }

    public function draft(): void
    {
        $this->active = false;
    }

    public function isActive(): bool
    {
        return $this->active == true;
    }

    public function getRating(): int
    {
        return $this->vote;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function attributeLabels()
    {
        return [
            'product_id' => tHelper::translate('shop/review','product_id'),
            'user_id' => tHelper::translate('shop/review','user_id'),
            'vote' => tHelper::translate('shop/review','vote'),
            'text' => tHelper::translate('shop/review','text'),
            'active' => tHelper::translate('shop/review','active'),
            'created_at' => tHelper::translate('shop/review','created_at'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%shop_reviews}}';
    }
}