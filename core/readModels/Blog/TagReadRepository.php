<?php


namespace core\readModels\Blog;


use core\entities\Blog\Tag;

class TagReadRepository
{
    public function findBySlug($slug): ?Tag
    {
        return Tag::findOne(['slug' => $slug]);
    }
}