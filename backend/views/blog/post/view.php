<?php

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $post schedule\entities\Blog\Post\Post */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="card card-secondary">
    <div class="card-header">
        <?php
        if ($post->isActive()): ?>
            <?= Html::a(
                'Draft',
                ['draft', 'id' => $post->id],
                [
                    'class' => 'btn btn-primary btn-sm btn-shadow bg-gradient text-shadow',
                    'data-method' => 'post'
                ]
            ) ?>
        <?php
        else: ?>
            <?= Html::a(
                'Activate',
                ['activate', 'id' => $post->id],
                [
                    'class' => 'btn btn-success btn-sm btn-shadow bg-gradient text-shadow',
                    'data-method' => 'post'
                ]
            ) ?>
        <?php
        endif; ?>
        <?= Html::a(
            'Update',
            ['update', 'id' => $post->id],
            ['class' => 'btn btn-primary btn-sm btn-shadow bg-gradient text-shadow']
        ) ?>
        <?= Html::a(
            'Delete',
            ['delete', 'id' => $post->id],
            [
                'class' => 'btn btn-danger btn-sm btn-shadow bg-gradient text-shadow',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
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
                        'value' => PostHelper::statusLabel($post->status),
                        'format' => 'raw',
                    ],
                    'title',
                    [
                        'attribute' => 'category_id',
                        'value' => ArrayHelper::getValue($post, 'category.name'),
                    ],
                    [
                        'label' => 'Tags',
                        'value' => implode(', ', ArrayHelper::getColumn($post->tags, 'name')),
                    ],
                ],
            ]
        ) ?>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">
        <h3>Photo</h3>
        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php
        if ($post->photo): ?>
            <?= Html::a(
                Html::img($post->getThumbFileUrl('photo', 'thumb')),
                $post->getUploadedFileUrl('photo'),
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
        <h3>Description</h3>
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
        <h3>Content</h3>
        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= Yii::$app->formatter->asNtext($post->content) ?>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">
        <h3>SEO</h3>
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
