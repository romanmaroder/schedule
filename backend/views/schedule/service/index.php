<?php

use hail812\adminlte3\assets\PluginAsset;
use core\entities\Schedule\Service\Service;
use core\helpers\PriceHelper;
use core\helpers\ServiceHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Schedule\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title                   ='Services';
$this->params['breadcrumbs'][] = ['label' => 'Service', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>
    <div class="service-index">
        <div class="invoice p-3 mb-3">
            <div class="card card-secondary">
                <div class="card-header">
                <h3 class="card-title ">
                    <?= Html::a('Create Service', ['create'], ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
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
                        'summary' => false,
                        'tableOptions' => [
                            'class' => 'table table-striped table-bordered',
                            'id' => 'service'
                        ],
                        'columns' => [
                            'id',
                            [
                                'attribute' => 'name',
                                'value' => function (Service $model) {
                                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'category_id',
                                'filter' => $searchModel->categoriesList(),
                                'value' => 'category.name',
                            ],
                            [
                                'attribute' => 'price_new',
                                'value' => function (Service $model) {
                                    return PriceHelper::format($model->price_new);
                                },
                            ],
                            [
                                'attribute' => 'price_old',
                                'value' => function (Service $model) {
                                    return PriceHelper::format($model->price_old);
                                },
                            ],
                            [
                                'attribute' => 'status',
                                'filter' => $searchModel->statusList(),
                                'value' => function (Service $model) {
                                    return ServiceHelper::statusLabel($model->status);
                                },
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'text-align:center'],
                            ]
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

<?php
$js = <<< JS
 $(function () {
 
    $('#service').DataTable({
        bDestroy: true,
       pageLength: -1, 
       paging: true,
       lengthChange: true,
       lengthMenu: [[10, 25, 50, -1], [ 10, 25, 50,"All"]],
       searching: true,
       ordering: false,
       info: false,
       autoWidth: false,
       responsive: true,
       bStateSave: true,
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
    }).buttons().container().appendTo('#service_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>