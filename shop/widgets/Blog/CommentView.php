<?php


namespace shop\widgets\Blog;


use core\entities\Blog\Post\Comment;

class CommentView
{
    public function __construct(public readonly Comment $comment, public array $children)
    {
    }
}