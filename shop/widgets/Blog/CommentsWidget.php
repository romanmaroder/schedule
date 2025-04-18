<?php


namespace shop\widgets\Blog;


use core\entities\Blog\Post\Comment;
use core\entities\Blog\Post\Post;
use core\forms\manage\Blog\CommentForm;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class CommentsWidget extends Widget
{
    /**
     * @var Post
     */
    public $post;

    public function init(): void
    {
        if (!$this->post) {
            throw new InvalidConfigException('Specify the post.');
        }
    }

    public function run(): string
    {
        $form = new CommentForm();

        $comments = $this->post->getComments()
            ->orderBy(['parent_id' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        $items = $this->treeRecursive($comments, null);

        return $this->render('comments/comments', [
            'post' => $this->post,
            'items' => $items,
            'commentForm' => $form,
        ]);
    }

    /**
     * @param Comment[] $comments
     * @param int|null $parentId
     * @return CommentView[]
     */
    public function treeRecursive(array &$comments, int|null $parentId): array
    {
        $items = [];
        foreach ($comments as $comment) {
            if ($comment->parent_id == $parentId) {
                $items[] = new CommentView($comment, $this->treeRecursive($comments, $comment->id));
            }
        }
        return $items;
    }
}