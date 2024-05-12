<?php


namespace schedule\readModels\Blog;


use schedule\entities\Blog\Tag;

class TagReadRepository
{
    public function findBySlug($slug): ?Tag
    {
        return Tag::findOne(['slug' => $slug]);
    }
}