<?php

use schedule\entities\Schedule\Category;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Schedule\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
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
                        [
                            'attribute' => 'name',
                            'value' => function (Category $model) {
                                $indent = ($model->depth > 1 ? str_repeat(
                                        '&nbsp;&nbsp;',
                                        $model->depth - 1
                                    ) . ' ' : '');
                                return $indent . Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'value' => function (Category $model) {
                                return
                                    Html::a('<i class="fas fa-arrow-up"></i>', ['move-up', 'id' => $model->id]) .
                                    Html::a('<i class="fas fa-arrow-down"></i>', ['move-down', 'id' => $model->id]);
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
        <!-- /.card-body -->
        <div class="card-footer">
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>
</div>