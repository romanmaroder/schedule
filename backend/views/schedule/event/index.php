<?php

use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Schedule\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);

/*echo '<pre>';
var_dump($searchModel);
var_dump($dataProvider->getModels());
die();*/

?>

    <div class="event-index">
        <div class="invoice p-3 mb-3">
            <div class="card card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'>
                        <?= Html::a('Create Event', ['create'], ['class' => 'btn btn-success btn-shadow']) ?>
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
                            'tableOptions' => [
                                'class' => 'table table-striped table-bordered',
                                'id' => 'event'
                            ],
                            'columns' => [

                                'id',
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
                                /* [
                                     'attribute' => 'start',
                                     'format' => ['datetime', 'php:Y-m-d / H:i']
                                 ],
                                 [
                                     'attribute' => 'end',
                                     'format' => ['datetime', 'php:Y-m-d / H:i']
                                 ],*/
                                [
                                    'attribute' => 'notice',
                                    'format' => 'ntext'
                                ],
                                [
                                    'attribute' => 'service',
                                    //'filter' =>  $searchModel->serviceList(),
                                    'value' => function ($model) {
                                       return implode(', ', ArrayHelper::getColumn($model->services, 'name'));},
                                ],
                                'amount'
                            ],
                        ]
                    ); ?>
                </div>
            </div>

        </div>

    </div>

<?php
$js = <<< JS
 $(function () {
 
    $('#event').DataTable({
    
       "paging": false,
       "lengthChange": false,
       "searching": true,
       "ordering": true,
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
         },
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>