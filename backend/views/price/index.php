<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\PriceSearch */

/* @var $dataProvider \yii\data\ActiveDataProvider */


use backend\assets\DataTableAsset;
use core\entities\User\Price;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('price', 'Prices');
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(['sweetalert2']);
PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
DataTableAsset::register($this);
?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">
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
                                'tableOptions' => [
                                    'class' => 'table table-striped table-bordered',
                                    'id' => 'price'
                                ],
                                'emptyText' => false,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    //'id',
                                    [
                                        'attribute' => 'name',
                                        'value' => fn(Price $model) => Html::a(
                                            Html::encode($model->name),
                                            ['view', 'id' => $model->id]
                                        ),
                                        'format' => 'raw',
                                    ],
                                    //'rate',
                                    [
                                        'attribute' => 'services',
                                        'value' => fn(Price $model) => implode(
                                            ' </br>',
                                            ArrayHelper::getColumn(
                                                $model->services,
                                                'name'
                                            )
                                        ),

                                        'format' => 'raw'
                                    ],

                                    [
                                        'attribute' => 'price',
                                        'value' => fn(Price $model) => implode(
                                            ' </br>',
                                            ArrayHelper::getColumn(
                                                $model->services,
                                                'price_new'
                                            )
                                        ),
                                        'format' => 'raw'
                                    ],
                                    [
                                        'attribute' => 'rate',
                                        'value' => fn(Price $model) => implode(
                                            ' </br>',
                                            ArrayHelper::getColumn(
                                                $model->serviceAssignments,
                                                'rate'
                                            )
                                        ),
                                        'format' => 'raw'
                                    ],
                                    [
                                        'attribute' => 'cost',
                                        'value' => fn(Price $model) => implode(
                                            ' </br>',
                                            ArrayHelper::getColumn(
                                                $model->serviceAssignments,
                                                'cost'
                                            )
                                        ),
                                        'format' => 'raw'
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{revoke}',
                                        'header' => Yii::t('price', 'Revoke'),
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
                                            'revoke' => fn($url, Price $model, $key) => ArrayHelper::getValue(
                                                ArrayHelper::getColumn(
                                                    $model->serviceAssignments,
                                                    fn($element) => Html::a(
                                                        Yii::t('app', '<i class="fas fa-trash"></i>'),
                                                        [
                                                            'price/revoke',
                                                            'id' => $model->id,
                                                            'service_id' => $element['service_id']
                                                        ],
                                                        [
                                                            'id' => 'delete',
                                                            'title' => Yii::t('app', 'Delete'),
                                                            'data' => [
                                                                'confirm' => Yii::t('app', 'Delete file?'),
                                                                'method' => 'POST',
                                                            ],
                                                        ]
                                                    ),
                                                ),
                                                null
                                            ),
                                        ],
                                    ],
                                    [
                                        'attribute' => 'Add',
                                        'value' => fn (Price $model) =>
                                             Html::a(
                                                '<i class="fas fa-plus-square fa-rotate-270 fa-lg" style="color: #28a745;"></i>',
                                                ['price/add', 'id' => $model->id,], [
                                                    'title' => Yii::t('price', 'Add'),
                                                ]
                                            ),
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
            </div>
        </div>
    </div>

<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#price').DataTable({
    bStateSave:true,
       paging: false,
       lengthChange: false,
       searching: true,
       ordering: false,
       info: false,
       autoWidth: false,
       responsive: true,
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