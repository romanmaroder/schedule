<?php


/* @var $this \yii\web\View */

/* @var $post \core\entities\Blog\Post\Post */

/* @var $comment \core\entities\Blog\Post\Comment */

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

$this->title =Html::encode( StringHelper::truncateWords(strip_tags($post->title), 3) );
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog','Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>

<div class="card card-secondary">
    <div class="card-header">

        <?= Html::a(
            Yii::t('app','Update'),
            ['update', 'post_id' => $post->id, 'id' => $comment->id],
            ['class' => 'btn btn-primary btn-sm btn-shadow btn-gradient']
        ) ?>
        <?php
        if ($comment->isActive()): ?>
            <?= Html::a(
                Yii::t('app','Delete'),
                ['delete', 'post_id' => $post->id, 'id' => $comment->id],
                [
                    'class' => 'btn btn-danger btn-sm btn-shadow btn-gradient',
                    'data' => [
                        'confirm' => Yii::t('app', 'Delete file?'),
                        'method' => 'post',
                    ],
                ]
            ) ?>
        <?php
        else: ?>
            <?= Html::a(
                Yii::t('app','Restore'),
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
                        [
                            'attribute' => 'user_id',
                            'value' => $comment->employee->getFullName(),
                        ],
                        'parent_id',
                        [
                            'attribute' => 'post_id',
                            'value' => Html::encode( StringHelper::truncateWords(strip_tags($post->title), 5) ),
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