<?php


/* @var $this \yii\web\View */

/* @var $post \core\entities\Blog\Post\Post */

/* @var $comment \core\entities\Blog\Post\Comment */

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>

<div class="card card-secondary">
    <div class="card-header">

        <?= Html::a(
            'Update',
            ['update', 'post_id' => $post->id, 'id' => $comment->id],
            ['class' => 'btn btn-primary btn-sm btn-shadow btn-gradient']
        ) ?>
        <?php
        if ($comment->isActive()): ?>
            <?= Html::a(
                'Delete',
                ['delete', 'post_id' => $post->id, 'id' => $comment->id],
                [
                    'class' => 'btn btn-danger btn-sm btn-shadow btn-gradient',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]
            ) ?>
        <?php
        else: ?>
            <?= Html::a(
                'Restore',
                ['activate', 'post_id' => $post->id, 'id' => $comment->id],
                [
                    'class' => 'btn btn-success btn-sm btn-shadow btn-gradient',
                    'data' => [
                        'confirm' => 'Are you sure you want to activate this item?',
                        'method' => 'post',
                    ],
                ]
            ) ?>
        <?php
        endif; ?>
        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="form-group">
            <?= DetailView::widget(
                [
                    'model' => $comment,
                    'attributes' => [
                        'id',
                        'created_at:boolean',
                        'active:boolean',
                        'user_id',
                        'parent_id',
                        [
                            'attribute' => 'post_id',
                            'value' => $post->title,
                        ],
                        [
                            'attribute' => 'text',
                            'value' => Yii::$app->formatter->asNtext($comment->text),
                        ]
                    ],
                ]
            ) ?>
        </div>
    </div>
</div>