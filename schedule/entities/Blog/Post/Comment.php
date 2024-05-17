<?php


namespace schedule\entities\Blog\Post;


use schedule\entities\Blog\Post\queries\PostQuery;
use schedule\entities\User\Employee\Employee;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $created_at
 * @property int $post_id
 * @property int $user_id
 * @property int $parent_id
 * @property string $text
 * @property bool $active
 *
 * @property Post $post
 * @property Employee $employee
 */
class Comment extends ActiveRecord
{
    public static function create($userId, $parentId, $text): self
    {
        $review = new static();
        $review->user_id = $userId;
        $review->parent_id = $parentId;
        $review->text = $text;
        $review->created_at = time();
        $review->active = true;
        return $review;
    }

    public function edit($parentId, $text): void
    {
        $this->parent_id = $parentId;
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

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function isChildOf($id): bool
    {
        return $this->parent_id == $id;
    }

    public function getPost(): ActiveQuery
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class,['user_id'=>'user_id']);
    }

    public static function tableName(): string
    {
        return '{{%blog_comments}}';
    }
}