<?php


namespace core\services\Blog;


use core\entities\Blog\Post\Comment;
use core\forms\manage\Blog\CommentForm;
use core\repositories\Blog\PostRepository;
use core\repositories\UserRepository;

class CommentService
{
    private $posts;
    private $users;

    public function __construct(PostRepository $posts, UserRepository $users)
    {
        $this->posts = $posts;
        $this->users = $users;
    }

    public function create($postId, $userId, CommentForm $form): Comment
    {
        $post = $this->posts->get($postId);
        $user = $this->users->get($userId);

        $comment = $post->addComment($user->id, $form->parentId, $form->text);

        $this->posts->save($post);

        return $comment;
    }
}