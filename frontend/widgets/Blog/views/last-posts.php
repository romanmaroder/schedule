<?php

/** @var $posts \schedule\entities\Blog\Post\Post[] */

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

?>
<div class="container-fluid">
    <div class="row">
        <?php foreach ($posts as $i => $post): ?>
            <?php $url = Url::to(['/blog/post/post', 'id' => $post->id]); ?>
            <? if ($i == 0) : ?>
                <div class="py-0">
                    <div class="container">
                        <div class="half-post-entry d-block d-lg-flex bg-light half-post-entry-shadow">
                            <?php
                            if ($post->files): ?>
                            <div class="img-bg" style="background-image: url('<?=$post->getThumbFileUrl('files', 'widget_last_post')?>')"></div>
                                <?
                                endif; ?>
                            <div class="contents">
                                <span class="caption"><?= Html::encode($post->category->name) ?></span>
                                <h2><a href="<?= Html::encode($url) ?>"><?= Html::encode($post->title) ?></a></h2>
                                <p class="mb-3 text-secondary"><?= Html::encode(
                                        StringHelper::truncateWords(strip_tags($post->description), 120)
                                    ) ?></p>
                                <div class="post-meta">
                                    <span class="d-block"><?= Html::a(
                                            Html::encode($post->category->name),
                                            [
                                                '/blog/post/category',
                                                'slug' => $post->category->slug
                                            ]
                                        ) ?></span>
                                    <span class="date-read"><?= Yii::$app->formatter->asDatetime(
                                            $post->created_at
                                        ); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? endif; ?>
        <?php endforeach; ?>

        <div class="site-section">
            <div class="container">
                <div class="row">
                    <?php foreach ($posts as $i => $post): ?>
                        <?php $url = Url::to(['/blog/post/post', 'id' => $post->id]); ?>
                        <?if($i >= 1):?>
                            <? if ($i % 2 == 0): ?>
                                <div class="col-lg-6">
                                    <div class="post-entry-2 d-flex">
                                        <div class="thumbnail thumbnail-shadow" style="background-image: url('<?=$post->getThumbFileUrl('files', 'widget_last_post_thumb')?>')"></div>
                                        <div class="contents">
                                            <h2><a href="<?= Html::encode($url) ?>"><?= Html::encode($post->title) ?></a>
                                            </h2>
                                            <p class="mb-3 text-secondary"><?= Html::encode(
                                                    StringHelper::truncateWords(strip_tags($post->description), 30)
                                                ) ?></p>
                                            <div class="post-meta">
                                                <span class="d-block"><?= Html::a(
                                                        Html::encode($post->category->name),
                                                        [
                                                            '/blog/post/category',
                                                            'slug' => $post->category->slug
                                                        ]
                                                    ) ?></span>
                                                <span class="date-read"><?= Yii::$app->formatter->asDatetime(
                                                        $post->created_at
                                                    ); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <? else: ?>
                                <div class="col-lg-6">
                                    <div class="post-entry-2 d-flex">
                                        <div class="thumbnail thumbnail-shadow" style="background-image: url('<?=$post->getThumbFileUrl('files', 'widget_last_post_thumb')?>')"></div>
                                        <div class="contents">
                                            <h2><a href="<?= Html::encode($url) ?>"><?= Html::encode(
                                                        $post->title
                                                    ) ?></a></h2>
                                            <p class="mb-3 text-secondary"><?= Html::encode(
                                                    StringHelper::truncateWords(strip_tags($post->description), 30)
                                                ) ?></p>
                                            <div class="post-meta">
                                                <span class="d-block"><?= Html::a(
                                                        Html::encode($post->category->name),
                                                        [
                                                            '/blog/post/category',
                                                            'slug' => $post->category->slug
                                                        ]
                                                    ) ?></span>
                                                <span class="date-read"><?= Yii::$app->formatter->asDatetime(
                                                        $post->created_at
                                                    ); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <? endif; ?>
                        <?endif;?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>