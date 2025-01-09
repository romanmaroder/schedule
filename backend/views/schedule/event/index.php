<?php

use backend\assets\DataTableAsset;
use core\entities\Enums\PaymentOptionsEnum;
use core\entities\Enums\StatusPayEnum;
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
    [
        'datatables',
        'datatables-bs4',
        'datatables-responsive',
        'datatables-searchbuilder'
    ]
);
DataTableAsset::register($this);

$this->title = Yii::t('app', 'Events');
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
                <div class="card card-secondary">
                    <div class='card-header'>
                        <h3 class='card-title'>
                            <?= Html::a(
                                Yii::t('app', 'Create'),
                                ['create'],
                                ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']
                            ) ?>
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
                                'showHeader' => true,
                                'showFooter' => true,
                                'tableOptions' => [
                                    'class' => 'table table-striped table-bordered',
                                    'id' => 'event'
                                ],
                                'columns' => [
                                    [
                                        'attribute' => 'start',
                                        'value' => fn($model) => DATE('Y-m-d', strtotime($model->start)),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'master_id',
                                        'value' => fn($model) => Html::a(
                                            Html::encode($model->master->username),
                                            ['view', 'id' => $model->id]
                                        ),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'client_id',
                                        'value' => fn($model) => Html::a(
                                            Html::encode($model->client->username),
                                            ['/user/view', 'id' => $model->client->id]
                                        ),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'service',
                                        'value' => fn($model) => implode(
                                            ', </br>',
                                            ArrayHelper::getColumn(
                                                $model->services,
                                                'name'
                                            )
                                        ),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'format' => 'raw'
                                    ],
                                    //'amount',
                                    [
                                        'attribute' => 'cost',
                                        'value' => fn(Event $models) => $models->getDiscountedPrice($models, $cart),
                                        'contentOptions' => fn($models) => [
                                            'data-total' => $models->getDiscountedPrice($models, $cart),
                                            'class' => ['text-center align-middle']
                                        ],
                                        //'footer' => $cart->getFullDiscountedCost(),
                                        'footerOptions' => ['class' => 'text-center bg-info'],
                                        'format' => 'raw'

                                    ],
                                    [
                                        'attribute' => 'status',
                                        'value' => fn($model) => EventPaymentStatusHelper::statusLabel($model->status),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'format' => 'raw',

                                    ],
                                    [
                                        'attribute' => 'payment',
                                        'value' => fn($model) => EventMethodsOfPayment::statusLabel($model->payment),
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
                                            'payment' => fn($model) => $model->status == StatusPayEnum::STATUS_PAYED->value,
                                        ],
                                        'buttons' => [
                                            'status' => fn(
                                                $url,
                                                $model,
                                                $key
                                            ) => $model->status == StatusPayEnum::STATUS_NOT_PAYED->value ? Html::a(
                                                '<i class="fas fa-ruble-sign"></i>',
                                                //Yii::t('schedule/event','Pay'),
                                                Url::to(['schedule/event/pay', 'id' => $model->id]),
                                                [
                                                    'class' => 'btn bg-success bg-gradient text-shadow box-shadow btn-xs',
                                                    'title' => Yii::t('schedule/event', 'Pay')
                                                ]
                                            ) : Html::a(
                                                '<i class="fas fa-ruble-sign"></i>',
                                                //Yii::t('schedule/event','No pay'),
                                                Url::to(['schedule/event/unpay', 'id' => $model->id]),
                                                [
                                                    'class' => 'btn bg-danger bg-gradient text-shadow box-shadow btn-xs',
                                                    'title' => Yii::t('schedule/event', 'No pay')
                                                ]
                                            ),
                                            'payment' => fn(
                                                $url,
                                                $model,
                                                $key
                                            ) => $model->payment == PaymentOptionsEnum::STATUS_CASH->value ? Html::a(
                                                '<i class="fab fa-cc-visa"></i>',

                                                Url::to(['schedule/event/card', 'id' => $model->id]),
                                                [
                                                    'class' => 'btn bg-info bg-gradient text-shadow box-shadow btn-xs',
                                                    'title' => Yii::t('schedule/event', 'Card')
                                                ]
                                            ) : Html::a(
                                                '<i class="fas fa-money-bill-wave-alt"></i>',
                                                //Yii::t('schedule/event','Cash'),
                                                Url::to(['schedule/event/cash', 'id' => $model->id]),
                                                [
                                                    'class' => 'btn bg-success bg-gradient text-shadow box-shadow btn-xs',
                                                    'title' => Yii::t('schedule/event', 'Cash')
                                                ]
                                            ),
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
                                            'payment' => fn($model) => $model->status == StatusPayEnum::STATUS_PAYED->value,
                                        ],
                                        'buttons' => [
                                            'copy' => fn($url, $model, $key) => Html::a(
                                                Yii::t('app', 'Copy'),
                                                Url::to(['schedule/event/copy', 'id' => $model->id]),
                                                ['class' => 'btn bg-info bg-gradient text-shadow box-shadow btn-xs']
                                            ),
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
        footerCallback: function ( row, data, start, end, display ) {
                var api = this.api();
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                i : 0;
                };
                
                 let totalCash = api
                                .column( 4)
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Total over this page
                           let pageTotalCash = api
                                .column( 4, { page: 'current'} )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Update footer
                            if ( pageTotalCash === 0 ){
                                 $( api.column( 4).footer() )
                                 .html('-');
                            }else{
                                 $( api.column( 4 ).footer() ).html(pageTotalCash);
                            }
                },
        language: {
          url:"$ru"
         },
         searchBuilder: {
                    columns: [0,1,2,3,5,6]
                }
    });
  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>