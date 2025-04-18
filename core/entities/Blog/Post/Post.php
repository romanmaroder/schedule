<?php


namespace core\entities\Blog\Post;


use core\entities\Enums\StatusEnum;
use core\helpers\tHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use romanmaroder\upload\ImageUploadBehavior;
use core\entities\behaviors\MetaBehavior;
use core\entities\Blog\Category;
use core\entities\Blog\Post\queries\PostQuery;
use core\entities\Blog\Tag;
use core\entities\Meta;
use core\services\WaterMarker;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;


/**
 * @property int $id
 * @property int $category_id
 * @property int $created_at
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $files [varchar(255)]
 * @property int $status
 * @property int $comments_count
 *
 * @property Meta $meta
 * @property Category $category
 * @property TagAssignment[] $tagAssignments
 * @property Tag[] $tags
 * @property string $meta_json [json]
 *
 * @property Comment[] $comments
 *
 * @mixin ImageUploadBehavior
 */
class Post extends ActiveRecord
{

    public $meta;

    public static function create($categoryId, $title, $description, $content, Meta $meta): self
    {
        $post = new static();
        $post->category_id = $categoryId;
        $post->title = $title;
        $post->description = $description;
        $post->content = $content;
        $post->meta = $meta;
        $post->status = StatusEnum::STATUS_INACTIVE;
        $post->created_at = time();
        $post->comments_count = 0;
        return $post;
    }

    public function addPhoto(UploadedFile $photo): void
    {
        $this->files = $photo;
    }


    public function edit($categoryId, $title, $description, $content, Meta $meta): void
    {
        $this->category_id = $categoryId;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->meta = $meta;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Post is already active.');
        }
        $this->status = StatusEnum::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Post is already draft.');
        }
        $this->status = StatusEnum::STATUS_INACTIVE;
    }

    public function isActive(): bool
    {
        return $this->status == StatusEnum::STATUS_ACTIVE->value;
    }


    public function isDraft(): bool
    {
        return $this->status == StatusEnum::STATUS_INACTIVE->value;
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->title;
    }

    // Tags

    public function assignTag($id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForTag($id)) {
                return;
            }
        }
        $assignments[] = TagAssignment::create($id);
        $this->tagAssignments = $assignments;
    }

    public function revokeTag($id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForTag($id)) {
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeTags(): void
    {
        $this->tagAssignments = [];
    }

    // Comments

    public function addComment($userId, $parentId, $text): Comment
    {
        $parent = $parentId ? $this->getComment($parentId) : null;
        if ($parent && !$parent->isActive()) {
            throw new \DomainException('Cannot add comment to inactive parent.');
        }
        $comments = $this->comments;
        $comments[] = $comment = Comment::create($userId, $parent?->id, $text);
        $this->updateComments($comments);
        return $comment;
    }

    public function editComment($id, $parentId, $text): void
    {
        $parent = $parentId ? $this->getComment($parentId) : null;
        $comments = $this->comments;
        foreach ($comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                $comment->edit($parent?->id, $text);
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Comment is not found.');
    }

    public function activateComment($id): void
    {
        $comments = $this->comments;
        foreach ($comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                $comment->activate();
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Comment is not found.');
    }

    public function removeComment($id): void
    {
        $comments = $this->comments;
        foreach ($comments as $i => $comment) {
            if ($comment->isIdEqualTo($id)) {
                if ($this->hasChildren($comment->id)) {
                    $comment->draft();
                } else {
                    unset($comments[$i]);
                }
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Comment is not found.');
    }

    public function getComment($id): Comment
    {
        foreach ($this->comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                return $comment;
            }
        }
        throw new \DomainException('Comment is not found.');
    }

    private function hasChildren($id): bool
    {
        foreach ($this->comments as $comment) {
            if ($comment->isChildOf($id)) {
                return true;
            }
        }
        return false;
    }

    private function updateComments(array $comments): void
    {
        $this->comments = $comments;
        $this->comments_count = count(array_filter($comments, function (Comment $comment) {
            return $comment->isActive();
        }));
    }

    ##########################

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }

    public function getTagAssignments(): ActiveQuery
    {
        return $this->hasMany(TagAssignment::class, ['post_id' => 'id']);
    }

    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    ##########################

    public static function tableName(): string
    {
        return '{{%blog_posts}}';
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['tagAssignments', 'comments'],
            ],
            'files'=>[
                'class' => ImageUploadBehavior::class,
                'attribute' => 'files',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/posts/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/posts/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'blog_list' => ['width' => 128, 'height' => 128],
                    'widget_list' => ['width' => 228, 'height' => 228],
                    'widget_last_post' => ['width' => 1900, 'height' => 1140],
                    'widget_last_post_thumb' => ['width' => 300, 'height' => 400],
                    'origin' => [
                        'processor' => [
                            new WaterMarker(1024, 768, '@frontend/web/img/logo.jpg'),
                            'process'
                        ]
                    ],
                ],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find(): PostQuery
    {
        return new PostQuery(static::class);
    }
    public function attributeLabels(): array
    {
        return [
            'title' => tHelper::translate('blog', 'Title'),
            'content' => tHelper::translate('blog', 'Content'),
            'category_id' => tHelper::translate('blog', 'Category'),
            'status' => tHelper::translate('blog', 'Status'),
            'created_at' => tHelper::translate('blog', 'Created At'),
            'meta.title' => tHelper::translate('meta', 'meta.title'),
            'meta.description' => tHelper::translate('meta', 'meta.description'),
            'meta.keywords' => tHelper::translate('meta', 'meta.keywords'),
            'tags' => tHelper::translate('blog/tag', 'tags'),
        ];
    }
}