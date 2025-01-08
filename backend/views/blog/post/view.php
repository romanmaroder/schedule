<?php

use core\helpers\StatusHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $post core\entities\Blog\Post\Post */
/* @var $modificationsProvider yii\data\ActiveDataProvider */


$this->title = Html::encode( StringHelper::truncateWords(strip_tags($post->title), 3) );
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog','Post'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);



?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <?php
                    if ($post->isActive()): ?>
                        <?= Html::a(
                            Yii::t('app','Draft'),
                            ['draft', 'id' => $post->id],
                            [
                                'class' => 'btn btn-primary btn-sm btn-shadow bg-gradient text-shadow',
                                'data-method' => 'post'
                            ]
                        ) ?>
                    <?php
                    else: ?>
                        <?= Html::a(
                            Yii::t('app','Activate'),
                            ['activate', 'id' => $post->id],
                            [
                                'class' => 'btn btn-success btn-sm btn-shadow bg-gradient text-shadow',
                                'data-method' => 'post'
                            ]
                        ) ?>
                    <?php
                    endif; ?>
                    <?= Html::a(
                        Yii::t('app','Update'),
                        ['update', 'id' => $post->id],
                        ['class' => 'btn btn-primary btn-sm btn-shadow bg-gradient text-shadow']
                    ) ?>
                    <?= Html::a(
                        Yii::t('app','Delete'),
                        ['delete', 'id' => $post->id],
                        [
                            'class' => 'btn btn-danger btn-sm btn-shadow bg-gradient text-shadow',
                            'data' => [
                                'confirm' => Yii::t('app', 'Delete file?'),
                                'method' => 'post',
                            ],
                        ]
                    ) ?>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= DetailView::widget(
                        [
                            'model' => $post,
                            'attributes' => [
                                'id',
                                [
                                    'attribute' => 'status',
                                    'value' => StatusHelper::statusLabel($post->status),
                                    'format' => 'raw',
                                ],
                                'title',
                                [
                                    'attribute' => 'category_id',
                                    'value' => ArrayHelper::getValue($post, 'category.name'),
                                ],
                                [
                                    'attribute' => 'tags',
                                    'value' => implode(', ', ArrayHelper::getColumn($post->tags, 'name')),
                                ],
                            ],
                        ]
                    ) ?>
                </div>
</div>

            <div class="card card-secondary">
                <div class="card-header">
                    <?=Yii::t('blog','Photo')?>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    if ($post->files): ?>
                        <?= Html::a(
                            Html::img($post->getThumbFileUrl('files','blog_list')),
                            $post->getUploadedFileUrl('files'),
                            [
                                'class' => 'thumbnail',
                                'target' => '_blank'
                            ]
                        ) ?>
                    <?php
                    endif; ?>
                </div>
</div>

            <div class="card card-secondary">
                <div class="card-header">
                    <?=Yii::t('blog','Description')?>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= Yii::$app->formatter->asNtext($post->description) ?>
                </div>
</div>

            <div class="card card-secondary">
                <div class="card-header">
                    <?=Yii::t('blog','Content')?>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= Yii::$app->formatter->asHtml($post->content, [
                        'Attr.AllowedRel' => array('nofollow'),
                        'HTML.SafeObject' => true,
                        'Output.FlashCompat' => true,
                        'HTML.SafeIframe' => true,
                        'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                    ]) ?>
                </div>
</div>

            <div class="card card-secondary">
                <div class="card-header">
                    SEO
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= DetailView::widget(
                        [
                            'model' => $post,
                            'attributes' => [
                                [
                                    'attribute' => 'meta.title',
                                    'value' => $post->meta->title,
                                ],
                                [
                                    'attribute' => 'meta.description',
                                    'value' => $post->meta->description,
                                ],
                                [
                                    'attribute' => 'meta.keywords',
                                    'value' => $post->meta->keywords,
                                ],
                            ],
                        ]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>