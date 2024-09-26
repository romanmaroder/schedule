<?php

/* @var $this yii\web\View */



/* @var $employee \core\entities\User\Employee\Employee */

/* @var $provider \core\entities\Schedule\Event\Event */

use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Cabinet';
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>

<div class="active tab-pane" id="events">
    <?= GridView::widget(
            [
                'dataProvider' => $provider,
                //'filterModel' => $searchModel,
                'summary' => false,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered',
                    'id' => 'event'
                ],
                'columns' => [
                    [
                        'attribute' => 'start',
                        'format' => ['datetime', 'php:d-m-Y']
                    ],
                    [
                        'attribute' => 'client_id',
                        'value' => function ($model) {
                            return Html::a(
                                Html::encode($model->client->username),
                                ['/user/view', 'id' => $model->client->id]
                            );
                        },
                        'contentOptions' => [
                            'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Service',
                       'value' => function ($provider) {
                            return implode(', </br>', ArrayHelper::getColumn($provider->services, 'name'));
                        },
                        'format' => 'raw',
                        'contentOptions' => [
                            'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'notice',
                        'contentOptions' => [
                            'class'=>'text-center',
                            'style'=>'max-width:150px'
                        ],
                        'format' => 'ntext'
                    ],

                    [
                        'attribute' => 'start',
                        'contentOptions' => [
                            'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => ['datetime', 'php: H:i']
                    ],
                    [
                        'attribute' => 'end',
                        'contentOptions' => [
                            'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => ['datetime', 'php: H:i']
                    ],

                ],
            ]
        ); ?>
</div>


<!--<div class="cabinet-index">

    <h2>Attach profile</h2>
    <?/*= yii\authclient\widgets\AuthChoice::widget(
        [
            'baseAuthUrl' => ['cabinet/network/attach'],
        ]
    ); */?>
</div>-->

<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#event').DataTable({
       bDestroy: true,
       paging: true,
       lengthChange: true,
       searching: true,
       ordering: true,
       //"order": [[0, 'desc']],
       info: false,
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
         }
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>