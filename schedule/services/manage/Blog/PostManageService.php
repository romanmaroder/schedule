<?php


namespace schedule\services\manage\Blog;


use schedule\entities\Blog\Post\Post;
use schedule\entities\Blog\Tag;
use schedule\entities\Meta;
use schedule\forms\manage\Blog\Post\PostForm;
use schedule\repositories\Blog\CategoryRepository;
use schedule\repositories\Blog\PostRepository;
use schedule\repositories\Blog\TagRepository;
use schedule\services\TransactionManager;

class PostManageService
{
    private $posts;
    private $categories;
    private $tags;
    private $transaction;

    public function __construct(
        PostRepository $posts,
        CategoryRepository $categories,
        TagRepository $tags,
        TransactionManager $transaction
    ) {
        $this->posts = $posts;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->transaction = $transaction;
    }

    public function create(PostForm $form): Post
    {
        $category = $this->categories->get($form->categoryId);

        $post = Post::create(
            $category->id,
            $form->title,
            $form->description,
            $form->content,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        if ($form->file) {
            $post->addPhoto($form->file);
        }

        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tags->get($tagId);
            $post->assignTag($tag->id);
        }

        $this->transaction->wrap(
            function () use ($post, $form) {
                foreach ($form->tags->newNames as $tagName) {
                    if (!$tag = $this->tags->findByName($tagName)) {
                        $tag = Tag::create($tagName, $tagName);
                        $this->tags->save($tag);
                    }
                    $post->assignTag($tag->id);
                }
                $this->posts->save($post);
            }
        );

        return $post;
    }

    public function edit($id, PostForm $form): void
    {
        $post = $this->posts->get($id);
        $category = $this->categories->get($form->categoryId);

        $post->edit(
            $category->id,
            $form->title,
            $form->description,
            $form->content,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        if ($form->file) {

                $post->addPhoto($form->file);

       }


        $this->transaction->wrap(
            function () use ($post, $form) {
                $post->revokeTags();
                $this->posts->save($post);

                foreach ($form->tags->existing as $tagId) {
                    $tag = $this->tags->get($tagId);
                    $post->assignTag($tag->id);
                }
                foreach ($form->tags->newNames as $tagName) {
                    if (!$tag = $this->tags->findByName($tagName)) {
                        $tag = Tag::create($tagName, $tagName);
                        $this->tags->save($tag);
                    }
                    $post->assignTag($tag->id);
                }


                $this->posts->save($post);
            }
        );
    }

    public function activate($id): void
    {
        $post = $this->posts->get($id);
        $post->activate();
        $this->posts->save($post);
    }

    public function draft($id): void
    {
        $post = $this->posts->get($id);
        $post->draft();
        $this->posts->save($post);
    }

    public function remove($id): void
    {
        $post = $this->posts->get($id);
        $this->posts->remove($post);
    }
}