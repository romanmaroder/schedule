<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\Blog\CommentSearch */

/* @var $dataProvider */

use hail812\adminlte3\assets\PluginAsset;
use schedule\entities\Blog\Post\Comment;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\web\YiiAsset;

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">
            <?=$this->title?>
        </h3>

        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    'created_at:datetime',
                    [
                        'attribute' => 'text',
                        'value' => function (Comment $model) {
                            return StringHelper::truncate(strip_tags($model->text), 100);
                        },
                    ],
                    [
                        'attribute' => 'active',
                        'filter' => $searchModel->activeList(),
                        'format' => 'boolean',
                    ],
                    ['class' => ActionColumn::class],
                ],
            ]
        ); ?>
    </div>
</div>
