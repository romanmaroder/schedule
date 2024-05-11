<?php

use schedule\entities\Blog\Category;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Blog\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">
            <?= Html::a(
                'Create Tag',
                ['create'],
                ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient text-shadow']
            ) ?>
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
                    'sort',
                    [
                        'attribute' => 'name',
                        'value' => function (Category $model) {
                            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    'slug',
                    'title',
                    //['class' => ActionColumn::class],
                ],
            ]
        ); ?>
    </div>
    <div class="card-footer">
        <!--Footer-->
    </div>
</div>
