<?php

use schedule\entities\Blog\Post\Post;
use schedule\helpers\PostHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Blog\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">
            <?= Html::a(
                'Create Post',
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
        <?= GridView::widget([
                                 'dataProvider' => $dataProvider,
                                 'filterModel' => $searchModel,
                                 'columns' => [
                                     [
                                         'value' => function (Post $model) {
                                             return $model->files ? Html::img(
                                                 $model->getThumbFileUrl('files', 'admin')
                                             ) : '';
                                         },
                                         'format' => 'raw',
                                         'contentOptions' => ['style' => 'width: 100px'],
                                     ],
                                     'id',
                                     'created_at:datetime',
                                     [
                                         'attribute' => 'title',
                                         'value' => function (Post $model) {
                                             return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                                         },
                                         'format' => 'raw',
                                     ],
                                     [
                                         'attribute' => 'category_id',
                                         'filter' => $searchModel->categoriesList(),
                                         'value' => 'category.name',
                                     ],
                                     [
                                         'attribute' => 'status',
                                         'filter' => $searchModel->statusList(),
                                         'value' => function (Post $model) {
                                             return PostHelper::statusLabel($model->status);
                                         },
                                         'format' => 'raw',
                                     ],
                                 ],
                             ]); ?>
    </div>
    <div class="card-footer">
        <!--Footer-->
    </div>
</div>
