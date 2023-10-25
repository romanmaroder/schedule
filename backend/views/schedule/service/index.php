<?php

use schedule\entities\Schedule\Service\Service;
use schedule\helpers\PriceHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Schedule\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="service-index">

    <p>
        <?= Html::a('Create Service', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="invoice p-3 mb-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title ">
                    Common
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
                                'value' => function (Service $model) {
                                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'category_id',
                                'filter' => $searchModel->categoriesList(),
                                'value' => 'category.name',
                            ],
                            [
                                'attribute' => 'price_new',
                                'value' => function (Service $model) {
                                    return PriceHelper::format($model->price_new);
                                },
                            ],
                            [
                                'attribute' => 'price_old',
                                'value' => function (Service $model) {
                                    return PriceHelper::format($model->price_old);
                                },
                            ],
                            [
                                'attribute' => 'price_intern',
                                'value' => function (Service $model) {
                                    return PriceHelper::format($model->price_intern);
                                },
                            ],
                            [
                                'attribute' => 'price_employee',
                                'value' => function (Service $model) {
                                    return PriceHelper::format($model->price_employee);
                                },
                            ],
                            /*[
                                'attribute' => 'status',
                                'filter' => $searchModel->statusList(),
                                'value' => function (Service $model) {
                                    return ServiceHelper::statusLabel($model->status);
                                },
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'text-align:center'],
                            ]*/
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
</div>