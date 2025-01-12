<?php


namespace shop\widgets\Blog;


use core\readModels\Blog\PostReadRepository;
use yii\base\Widget;

class LastPostsWidget extends Widget
{
    public function __construct(public $limit, private readonly PostReadRepository $repository, $config = [])
    {
        parent::__construct($config);
    }

    public function run(): string
    {
        return $this->render('last-posts', [
            'posts' => $this->repository->getLast($this->limit)
        ]);
    }
}