<?php



/* @var $this \yii\web\View */
/* @var $searchModel \backend\forms\Schedule\FreeTimeSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */


use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);

$this->title = 'Free time';
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="free-time-index">
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
                                'id' => 'free'
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
                                    'attribute' => 'additional_id',
                                    'value' => function ($model) {
                                        return Html::a(
                                            Html::encode($model->additional->name),
                                            ['/schedule/additional-category/view', 'id' => $model->additional->category_id]
                                        );
                                    },
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'notice',
                                    'value' => function ($model) {
                                        return $model->notice;
                                    },
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => [
                                        'class' => ['text-center align-middle']
                                    ],
                                    'format' => 'raw',

                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{copy}',
                                    //'header' => '<i class="fas fa-cash-register"></i>',
                                    'header' => 'Copy',
                                    'headerOptions' => [
                                        'class'=>'text-center'
                                    ],
                                    'contentOptions' => [
                                        'class' => ['text-center align-middle']
                                    ],
                                    'buttonOptions' => [
                                        'class'=>'text-center'
                                    ],
                                    'buttons' => [
                                        'copy' => function ($url, $model, $key) {
                                            return  Html::a(
                                                'COPY',
                                                Url::to(['schedule/free-time/copy', 'id' => $model->id]),
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
$js = <<< JS
 $(function () {
 
    $('#free').DataTable({
    
       "paging": true,
       "lengthChange": false,
       "searching": true,
       "ordering": true,
       "info": true,
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