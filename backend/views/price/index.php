<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\PriceSearch */

/* @var $dataProvider \yii\data\ActiveDataProvider */


use core\entities\User\Price;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;

$this->title = 'Prices';
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(['sweetalert2']);
PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">
                <?= Html::a(
                    'Create Price',
                    ['create'],
                    ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']
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

            <?= GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'tableOptions' => [
                        'class' => 'table table-striped table-bordered',
                        'id' => 'price'
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        [
                            'attribute' => 'name',
                            'value' => function (Price $model) {
                                return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                            },
                            'format' => 'raw',
                        ],
                        //'rate',
                        [
                            'attribute' => 'service',
                            'value' => function (Price $model) {
                                return implode(' </br>', ArrayHelper::getColumn($model->services, 'name'));
                            },

                            'format' => 'raw'
                        ],

                        [
                            'attribute' => 'Price',
                            'value' => function (Price $model) {
                                return implode(' </br>', ArrayHelper::getColumn($model->services, 'price_new'));
                            },
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'Rate',
                            'value' => function (Price $model) {
                                return implode(' </br>', ArrayHelper::getColumn($model->serviceAssignments, 'rate'));
                            },
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'Cost',
                            'value' => function (Price $model) {
                                return implode(' </br>', ArrayHelper::getColumn($model->serviceAssignments, 'cost'));
                            },
                            'format' => 'raw'
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{revoke}',
                            'header' => 'Revoke',
                            'headerOptions' => [
                                'class' => 'text-center'
                            ],
                            'contentOptions' => [
                                'class' => ['text-center ']
                            ],
                            'buttonOptions' => [
                                'class' => 'text-center'
                            ],
                            'visibleButtons' => true,
                            'buttons' => [
                                'revoke' => function ($url, Price $model, $key) {
                                    $result = ArrayHelper::getColumn(
                                        $model->serviceAssignments,
                                        function ($element) use ($model) {
                                            return Html::a(
                                                Yii::t('app', '<i class="fas fa-trash"></i>'),
                                                [
                                                    'price/revoke',
                                                    'id' => $model->id,
                                                    'service_id' => $element['service_id']
                                                ],
                                                [
                                                    'id' => 'delete',
                                                    'data' => [
                                                        'confirm' => Yii::t('app', 'Delete file?'),
                                                        'method' => 'POST',
                                                    ],
                                                ]
                                            );
                                        }
                                    );
                                    $link = '';
                                    foreach ($result as $item) {
                                        $link .= $item . '</br>';
                                    }
                                    return $link;
                                },
                            ],
                        ],
                        [
                            'attribute' => 'Add',
                            'value' => function (Price $model) {
                                return Html::a(
                                    '<i class="fas fa-plus-square fa-rotate-270 fa-lg" style="color: #28a745;"></i>',
                                    ['price/add', 'id' => $model->id]
                                );
                            },
                            'headerOptions' => [
                                'class' => 'text-center'
                            ],
                            'contentOptions' => [
                                'class' => ['text-center align-middle']
                            ],
                            'format' => 'raw'
                        ],
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


<?php
$js = <<< JS
 $(function () {
 
    $('#price').DataTable({
    
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
         }
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>