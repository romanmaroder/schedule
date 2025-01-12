<?php


namespace frontend\widgets\Blog;


use core\entities\Blog\Post\Comment;

class CommentView
{
    public function __construct(public Comment $comment,public array $children)
    {
    }
}