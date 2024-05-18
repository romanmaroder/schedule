<?php


/* @var $this \yii\web\View */

/* @var $page \schedule\entities\Page */


use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card card-secondary">
    <div class="card-header">
        <?= Html::a('Update', ['update', 'id' => $page->id], ['class' => 'btn btn-primary btn-sm btn-gradient btn-shadow']) ?>
        <?= Html::a(
            'Delete',
            ['delete', 'id' => $page->id],
            [
                'class' => 'btn btn-danger btn-sm btn-gradient btn-shadow',
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
                'model' => $page,
                'attributes' => [
                    'id',
                    'title',
                    'slug',
                ],
            ]
        ) ?>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">
        Content
        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= Yii::$app->formatter->asNtext($page->content) ?>
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
                'model' => $page,
                'attributes' => [
                    'meta.title',
                    'meta.description',
                    'meta.keywords',
                ],
            ]
        ) ?>
    </div>
</div>
