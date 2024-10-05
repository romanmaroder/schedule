<?php

/* @var $this yii\web\View */

/* @var $post core\entities\Blog\Post\Post */

use frontend\widgets\Blog\CommentsWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;

//$this->title = $post->getSeoTitle();
$this->title = Html::encode( StringHelper::truncateWords(strip_tags($post->title), 3) );

$this->registerMetaTag(['name' => 'description', 'content' => $post->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $post->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('blog','Blog'), 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => $post->category->name,
    'url' => ['category', 'slug' => $post->category->slug]
];
$this->params['breadcrumbs'][] = $this->title;

$this->params['active_category'] = $post->category;

$tagLinks = [];
foreach ($post->tags as $tag) {
    $tagLinks[] = Html::a(Html::encode($tag->name), ['tag', 'slug' => $tag->slug]);
}
?>


<p class="mb-5">
    <?php
    if ($post->files): ?>
        <img src="<?= Html::encode($post->getThumbFileUrl('files', 'origin')) ?>" alt="Image1" class="img-fluid thumbnail-shadow"/>
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
                 class="img-fluidid thumbnail-shadow"/>
        <?php
        endif; ?>
    </div>
    <div class="vcard">
        <span class="d-block"><a href="#"><?=Yii::t('app','Education')?></a></span>
        <span class="date-read"><i class="far fa-calendar-alt"></i> <?= Yii::$app->formatter->asDatetime(
                $post->created_at
            ); ?></span>
    </div>
</div>
<p><?= Yii::$app->formatter->asHtml($post->content, [
        'Attr.AllowedRel' => array('nofollow'),
        'HTML.SafeObject' => true,
        'Output.FlashCompat' => true,
        'HTML.SafeIframe' => true,
        'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
    ]) ?></p>
<div class="pt-5">
    <p><?=Yii::t('blog/category','Categories')?>:
        <?= Html::a(Html::encode($post->category->name),['category', 'slug' => $post->category->slug])?>
        <?=Yii::t('blog/tag','Tags')?>:
        <a href="#">#<?= implode(', ', $tagLinks) ?></a>
    </p>
</div>

    <?= CommentsWidget::widget(
        [
            'post' => $post,
        ]
    ) ?>




