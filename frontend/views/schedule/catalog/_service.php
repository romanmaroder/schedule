<?php

use hail812\adminlte3\assets\PluginAsset;
use schedule\entities\Schedule\Service\Service;
use schedule\helpers\PriceHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>
    <div class="service-index">

        <div class="invoice p-3 mb-3 mb-md-0">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title ">
                        Common
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize" title="Maximize">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= GridView::widget(
                        [
                            'dataProvider' => $dataProvider,
                            'tableOptions' => [
                                'class' => 'table table-striped table-bordered',
                                'id' => 'service'
                            ],
                            'columns' => [
                                'id',
                                [
                                    'attribute' => 'parent category',
                                    'value' => function (Service $model) {
                                        return Html::a(Html::encode($model->category->parent->name),
                                                       ['view', 'id' => $model->category->parent->id]);
                                        },
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'name',
                                    'value' => function (Service $model) {
                                        return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                                    },
                                    'format' => 'raw',
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
                                    'attribute' => 'price_intern',
                                    'value' => function (Service $model) {
                                        return PriceHelper::format($model->price_intern);
                                    },
                                ],
                                [
                                    'attribute' => 'price_employee',
                                    'value' => function (Service $model) {
                                        return PriceHelper::format($model->price_employee);
                                    },
                                ],
                                /*[
                                    'attribute' => 'status',
                                    //'filter' => $searchModel->statusList(),
                                    'value' => function (Service $model) {
                                        return ServiceHelper::statusLabel($model->status);
                                    },
                                    'format' => 'raw',
                                    'contentOptions' => ['style' => 'text-align:center'],
                                ]*/
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
    
       "pageLength": 3, 
       "paging": true,
       "lengthChange": false,
       "searching": true,
       "ordering": true,
       "info": false,
       "autoWidth": false,
       "responsive": true,
       //"dom": "<'row'<'col-6 col-md-6 order-3 order-md-1 text-left'B><'col-sm-12 order-md-2 col-md-6 d-flex d-md-block'f>>tp",
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