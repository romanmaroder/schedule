<?php


namespace core\entities\Blog\Post;


use core\entities\User\Employee\Employee;
use core\helpers\tHelper;
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

    public function isEmployee(): bool
    {
        return isset($this->employee->user_id);
    }

    public function getPost(): ActiveQuery
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['user_id' => 'user_id']);
    }
    public function attributeLabels()
    {
        return [
            'created_at' => tHelper::translate('blog/comments', 'Created At'),
            'post_id' => tHelper::translate('blog/comments', 'Post Id'),
            'user_id' => tHelper::translate('blog/comments', 'User Id'),
            'parent_id' => tHelper::translate('blog/comments', 'Parent Id'),
            'text' => tHelper::translate('blog/comments', 'Text'),
            'active' => tHelper::translate('blog/comments', 'Active'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%blog_comments}}';
    }
}