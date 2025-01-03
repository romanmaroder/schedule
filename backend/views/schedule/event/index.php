<?php

use backend\assets\DataTableAsset;
use core\entities\Schedule\Event\Event;
use core\helpers\EventMethodsOfPayment;
use core\helpers\EventPaymentStatusHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Schedule\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $cart \core\cart\schedule\Cart */

PluginAsset::register($this)->add(
    ['datatables',
        'datatables-bs4',
        'datatables-responsive',
        'datatables-searchbuilder'
    ]
);
DataTableAsset::register($this);

$this->title = Yii::t('app','Events');
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
                <div class="card card-secondary">
                    <div class='card-header'>
                        <h3 class='card-title'>
                            <?= Html::a(Yii::t('app','Create'), ['create'], ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
                    </h3>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i
                                    class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i
                                    class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= GridView::widget(
                        [
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'summary' => false,
                            'emptyText' => false,
                            'tableOptions' => [
                                'class' => 'table table-striped table-bordered',
                                'id' => 'event'
                            ],
                            'columns' => [
                                [
                                    'attribute' => 'start',
                                    'value' => function ($model) {
                                        return DATE('Y-m-d', strtotime($model->start));
                                    },
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => [
                                        'class' => ['text-center align-middle']
                                    ],
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'master_id',
                                    'value' => function ($model) {
                                        return Html::a(
                                            Html::encode($model->master->username),
                                            ['view', 'id' => $model->id]
                                        );
                                    },'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'client_id',
                                    'value' => function ($model) {
                                        return Html::a(
                                            Html::encode($model->client->username),
                                            ['/user/view', 'id' => $model->client->id]
                                        );
                                    },'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'service',
                                    'value' => function ($model) {
                                        return implode(', </br>', ArrayHelper::getColumn($model->services, 'name'));
                                    },
                                    'contentOptions' => [
                                        'class' => ['text-center align-middle']
                                    ],
                                    'format' => 'raw'
                                ],
                                //'amount',
                                [
                                    'attribute' => 'cost',
                                    'value' => function (Event $models) use ($cart) {
                                        return $models->getDiscountedPrice($models, $cart);
                                    }
                                ],
                                [
                                    'attribute' => 'status',
                                    'value' => function ($model) {
                                        return EventPaymentStatusHelper::statusLabel($model->status);
                                    },
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => [
                                        'class' => ['text-center align-middle']
                                    ],
                                    'format' => 'raw',

                                ],
                                [
                                    'attribute' => 'payment',
                                    'value' => function ($model) {
                                        return EventMethodsOfPayment::statusLabel($model->payment);
                                    },
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => [
                                        'class' => ['text-center align-middle']
                                    ],
                                    'format' => 'raw',
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{status} {payment}',
                                    'header' => '<i class="far fa-credit-card"></i>',
                                    //'header' => Yii::t('schedule/event','Cash register'),
                                    'headerOptions' => [
                                        'class' => 'text-center'
                                    ],
                                    'contentOptions' => [
                                        'class' => ['text-center align-middle']
                                    ],
                                    'buttonOptions' => [
                                        'class' => 'text-center'
                                    ],
                                    'visibleButtons' => [
                                        'status' => true,
                                        'payment' => function ($model) {
                                            return $model->status == 1;
                                        },
                                    ],
                                    'buttons' => [
                                        'status' => function ($url, $model, $key) {
                                            return $model->status == 0 ? Html::a(
                                                    '<i class="fas fa-ruble-sign"></i>',
                                                //Yii::t('schedule/event','Pay'),
                                                Url::to(['schedule/event/pay', 'id' => $model->id]),
                                                ['class' => 'btn bg-success bg-gradient text-shadow box-shadow btn-xs',
                                                        'title'=>Yii::t('schedule/event','Pay')]
                                            ) : Html::a(
                                                    '<i class="fas fa-ruble-sign"></i>',
                                                //Yii::t('schedule/event','No pay'),
                                                Url::to(['schedule/event/unpay', 'id' => $model->id]),
                                                ['class' => 'btn bg-danger bg-gradient text-shadow box-shadow btn-xs',
                                                        'title'=>Yii::t('schedule/event','No pay')]
                                            );
                                        },
                                        'payment' => function ($url, $model, $key) {
                                            return $model->payment == 2 ? Html::a(
                                                    '<i class="fab fa-cc-visa"></i>',

                                                Url::to(['schedule/event/card', 'id' => $model->id]),
                                                ['class' => 'btn bg-info bg-gradient text-shadow box-shadow btn-xs',
                                                    'title'=>Yii::t('schedule/event','Card')]
                                            ) : Html::a(
                                                    '<i class="fas fa-money-bill-wave-alt"></i>',
                                                //Yii::t('schedule/event','Cash'),
                                                Url::to(['schedule/event/cash', 'id' => $model->id]),
                                                ['class' => 'btn bg-success bg-gradient text-shadow box-shadow btn-xs',
                                                        'title'=>Yii::t('schedule/event','Cash')]
                                            );
                                        },
                                    ],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{copy}',
                                    'header' => '<i class="far fa-copy"></i>',
                                    //'header' => Yii::t('app','Copy'),
                                    'headerOptions' => [
                                        'class' => 'text-center'
                                    ],
                                    'contentOptions' => [
                                        'class' => ['text-center align-middle']
                                    ],
                                    'buttonOptions' => [
                                        'class' => 'text-center'
                                    ],
                                    'visibleButtons' => [
                                        'status' => true,
                                        'payment' => function ($model) {
                                            return $model->status == 1;
                                        },
                                    ],
                                    'buttons' => [
                                        'copy' => function ($url, $model, $key) {
                                            return Html::a(
                                                Yii::t('app','Copy'),
                                                Url::to(['schedule/event/copy', 'id' => $model->id]),
                                                ['class' => 'btn bg-info bg-gradient text-shadow box-shadow btn-xs']
                                            );
                                        },
                                    ],
                                ],
                            ],
                        ]
                    ); ?>
                </div>
                </div>
            </div>
        </div>
    </div>

<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#event').DataTable({
        pageLength: 10, 
        paging: true,
        lengthChange: true,
        lengthMenu: [[10, 25, 50, -1], [ 10, 25, 50,"All"]],
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        responsive: true,
        bStateSave: true,
        fnStateSave: function (oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
                },
                fnStateLoad: function () {
                var data = localStorage.getItem('DataTables_' + window.location.pathname);
                return JSON.parse(data);
                },
         dom:'<"row"<"col-12 btn-sm"Q><"col-auto"l>> t <"row"<"col-12 mb-2 mb-md-0 col-md-6"i><"col-12 col-md-6"p>> ',
        language: {
          url:"$ru"
         },
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>