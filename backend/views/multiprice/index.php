<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\MultipriceSearch */

/* @var $dataProvider \yii\data\ActiveDataProvider */


use core\entities\User\MultiPrice;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Multi Prices';
$this->params['breadcrumbs'][] = $this->title;

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
                            'value' => function (MultiPrice $model) {
                                return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                            },
                            'format' => 'raw',
                        ],
                        //'rate',
                        [
                            'attribute' => 'service',
                            'value' => function (MultiPrice $model) {
                                return implode(' </br>', ArrayHelper::getColumn($model->services, 'name'));
                            },

                            'format' => 'raw'
                        ],

                        [
                            'attribute' => 'Price',
                            'value' => function (MultiPrice $model) {
                                return implode(' </br>', ArrayHelper::getColumn($model->services, 'price_new'));
                            },
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'Rate',
                            'value' => function (MultiPrice $model) {
                                return implode(' </br>', ArrayHelper::getColumn($model->serviceAssignments, 'rate'));
                            },
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'Cost',
                            'value' => function (MultiPrice $model) {
                                return implode(' </br>', ArrayHelper::getColumn($model->serviceAssignments, 'cost'));
                            },
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'Add',
                            'value' => function (MultiPrice $model) {
                                return Html::a('Add',['multiprice/add','id'=>$model->id]);
                            },
                            'format' => 'raw'
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{edit}',
                            //'header' => '<i class="fas fa-cash-register"></i>',
                            'header' => 'Edit',
                            'headerOptions' => [
                                'class' => 'text-center'
                            ],
                            'contentOptions' => [
                                'class' => ['text-center align-middle']
                            ],
                            'buttonOptions' => [
                                'class' => 'text-center'
                            ],
                            'visibleButtons' => true,
                            'buttons' => [
                                'edit' => function ($url, MultiPrice $model, $key) {
                                    $result = ArrayHelper::getColumn(
                                        $model->serviceAssignments,
                                        function ($element) use ($model) {
                                            return Html::a(
                                                'Edit',
                                                [
                                                    'multiprice/edit',
                                                    'id' => $model->id,
                                                    //'price_id' => $element['price_id'],
                                                    'service_id' => $element['service_id']
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