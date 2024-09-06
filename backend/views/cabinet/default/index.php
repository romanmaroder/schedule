<?php

/* @var $this yii\web\View */

/* @var $user \core\entities\User\User */

/* @var $employee \core\entities\User\Employee\Employee */

/* @var $provider \core\entities\Schedule\Event\Event */

use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Cabinet';
$this->params['breadcrumbs'][] = $this->title;
$this->params['user'] = $user;

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
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Service',
                        'value' => function ($provider) {
                            return implode(', ', ArrayHelper::getColumn($provider->services, 'name'));
                        },
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
                        'value'=>function ($model){
                            return substr($model['start'],10,6) . ' - ' . substr($model['end'],10,6);
                        },
                    ],/*
                    [
                        'attribute' => 'start',
                        'format' => ['datetime', 'php: H:i']
                    ],
                    [
                        'attribute' => 'end',
                        'format' => ['datetime', 'php: H:i']
                    ],*/

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
    
       "paging": true,
       "lengthChange": true,
       "searching": true,
       "ordering": true,
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