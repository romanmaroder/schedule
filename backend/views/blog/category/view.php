<?php

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $category schedule\entities\Blog\Category */

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="card card-secondary">
    <div class="card-header">
        <?= Html::a(
            'Update',
            ['update', 'id' => $category->id],
            ['class' => 'btn btn-primary btn-sm btn-shadow bg-gradient text-shadow']
        ) ?>
        <?= Html::a(
            'Delete',
            ['delete', 'id' => $category->id],
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
                'model' => $category,
                'attributes' => [
                    'id',
                    'name',
                    'slug',
                    'title',
                    'sort',
                ],
            ]
        ) ?>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">
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
                'model' => $category,
                'attributes' => [
                    'meta.title',
                    'meta.description',
                    'meta.keywords',
                ],
            ]
        ) ?>
    </div>
</div>
