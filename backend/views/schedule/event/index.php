<?php

use core\entities\Schedule\Event\Event;
use hail812\adminlte3\assets\PluginAsset;
use core\helpers\EventMethodsOfPayment;
use core\helpers\EventPaymentStatusHelper;
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
        'datatables-searchbuilder',
        'datatables-buttons']
);

$this->title = 'Event';
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="event-index">
        <div class="invoice p-3 mb-3">
            <div class="card card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'>
                        <?= Html::a('Create Event', ['create'], ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
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
                            'tableOptions' => [
                                'class' => 'table table-striped table-bordered',
                                'id' => 'event'
                            ],
                            'columns' => [

                                //'id',
                                [
                                    'attribute' => 'start',
                                    'format' => ['date', 'php:d-m-Y'],
                                ],
                                [
                                    'attribute' => 'master_id',
                                    'value' => function ($model) {
                                        return Html::a(
                                            Html::encode($model->master->username),
                                            ['view', 'id' => $model->id]
                                        );
                                    },
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'client_id',
                                    'value' => function ($model) {
                                        return Html::a(
                                            Html::encode($model->client->username),
                                            ['/user/view', 'id' => $model->client->id]
                                        );
                                    },
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'service',
                                    'value' => function ($model) {
                                        return implode(', </br>', ArrayHelper::getColumn($model->services, 'name'));
                                    },
                                    'format' => 'raw'
                                ],
                                //'amount',
                                [
                                    'attribute' => 'Cost',
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
                                    //'header' => '<i class="fas fa-cash-register"></i>',
                                    'header' => 'Cash register',
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
                                                'PAY',
                                                Url::to(['schedule/event/pay', 'id' => $model->id]),
                                                ['class' => 'btn bg-success bg-gradient text-shadow box-shadow btn-xs']
                                            ) : Html::a(
                                                'NO PAYED',
                                                Url::to(['schedule/event/unpay', 'id' => $model->id]),
                                                ['class' => 'btn bg-danger bg-gradient text-shadow box-shadow btn-xs']
                                            );
                                        },
                                        'payment' => function ($url, $model, $key) {
                                            return $model->payment == 2 ? Html::a(
                                                'CARD',
                                                Url::to(['schedule/event/card', 'id' => $model->id]),
                                                ['class' => 'btn bg-info bg-gradient text-shadow box-shadow btn-xs']
                                            ) : Html::a(
                                                'CASH',
                                                Url::to(['schedule/event/cash', 'id' => $model->id]),
                                                ['class' => 'btn bg-success bg-gradient text-shadow box-shadow btn-xs']
                                            );;
                                        },
                                    ],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{copy}',
                                    //'header' => '<i class="fas fa-cash-register"></i>',
                                    'header' => 'Copy',
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
                                                'COPY',
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

<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#event').DataTable({
        bDestroy: true,
        pageLength: -1, 
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
        // "dom": "<'row'<'col-6 col-md-6 order-3 order-md-1 text-left'B><'col-sm-12 order-md-2 col-md-6 d-flex d-md-block'f>>tp",
      // "buttons": [
      //   {
		// 		"text": "Добавить категорию",
		// 		"className":"btn btn-success",
		// 		"tag":"a",
		// 		"attr":{
		// 		//"href":create
		// 		},
		// 		/*"action": function ( e, dt, node, config ) {
		// 		  $(location).attr('href',config.attr.href);
		// 		}*/
      //   }
      //   ],
        language: {
          url:"$ru"
         },
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>