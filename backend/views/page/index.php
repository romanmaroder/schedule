<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\PageSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $searchModel backend\forms\PageSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use schedule\entities\Page;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">
            <?= Html::a('Create Page', ['create'], ['class' => 'btn btn-success btn-sm btn-gradient btn-shadow']) ?>
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
                    [
                        'attribute' => 'title',
                        'value' => function (Page $model) {
                            $indent = ($model->depth > 1 ? str_repeat(
                                    '&nbsp;&nbsp;',
                                    $model->depth - 1
                                ) . ' ' : '');
                            return $indent . Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'value' => function (Page $model) {
                            return
                                Html::a(
                                    '<span class="glyphicon glyphicon-arrow-up"></span>',
                                    ['move-up', 'id' => $model->id]
                                ) .
                                Html::a(
                                    '<span class="glyphicon glyphicon-arrow-down"></span>',
                                    ['move-down', 'id' => $model->id]
                                );
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'text-align: center'],
                    ],
                    'slug',
                    'title',
                    ['class' => ActionColumn::class],
                ],
            ]
        ); ?>
    </div>
</div>
