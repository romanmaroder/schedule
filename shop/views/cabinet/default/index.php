<?php

/* @var $this yii\web\View */



/* @var $employee \core\entities\User\Employee\Employee */

/* @var $provider \core\entities\Schedule\Event\Event */

use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
                        'value' => fn ($model) =>
                            Html::a(
                                Html::encode($model->client->username),
                                ['/user/view', 'id' => $model->client->id]
                            ),
                        'contentOptions' => [
                            'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Service',
                        'value' => fn ($provider) =>
                             implode(', ', ArrayHelper::getColumn($provider->services, 'name')),
                        'contentOptions' => [
                            'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'notice',
                        'contentOptions' => [
                            'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
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
$js = <<< JS
 $(function () {
 
    $('#event').DataTable({
    
       "paging": false,
       "lengthChange": false,
       "searching": true,
       "ordering": false,
       //"order": [[0, 'desc']],
       "info": false,
       "autoWidth": false,
       "responsive": true,
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
        "language": {
          "search":"Поиск"
         }
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>