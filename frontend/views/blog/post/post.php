<?php

/* @var $this yii\web\View */

/* @var $post schedule\entities\Blog\Post\Post */

use frontend\widgets\Blog\CommentsWidget;
use yii\helpers\Html;

//$this->title = $post->getSeoTitle();
$this->title = $post->title;

$this->registerMetaTag(['name' => 'description', 'content' => $post->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $post->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => 'Blog', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => $post->category->name,
    'url' => ['category', 'slug' => $post->category->slug]
];
$this->params['breadcrumbs'][] = $post->title;

$this->params['active_category'] = $post->category;

$tagLinks = [];
foreach ($post->tags as $tag) {
    $tagLinks[] = Html::a(Html::encode($tag->name), ['tag', 'slug' => $tag->slug]);
}
?>


<p class="mb-5">
    <?php
    if ($post->files): ?>
        <img src="<?= Html::encode($post->getThumbFileUrl('files', 'origin')) ?>" alt="Image1" class="img-fluid"/>
    <?php
    endif; ?>
</p>
<h1 class="mb-4">
    <?= Html::encode($post->title) ?>
</h1>
<div class="post-meta d-flex mb-5">
    <div class="bio-pic mr-3">
        <?php
        if ($post->files): ?>
            <img src="<?= Html::encode($post->getThumbFileUrl('files', 'blog_list')) ?>" alt="Image"
                 class="img-fluidid"/>
        <?php
        endif; ?>
    </div>
    <div class="vcard">
        <span class="d-block"><a href="#">Education</a></span>
        <span class="date-read"><i class="far fa-calendar-alt"></i> <?= Yii::$app->formatter->asDatetime(
                $post->created_at
            ); ?></span>
    </div>
</div>
<p><?= Yii::$app->formatter->asNtext($post->content) ?></p>
<div class="pt-5">
    <p>Categories: <a href="#"><?= $post->category->name ?></a> Tags: <a href="#">#<?= implode(', ', $tagLinks) ?></a>
    </p>
</div>

    <?= CommentsWidget::widget(
        [
            'post' => $post,
        ]
    ) ?>




