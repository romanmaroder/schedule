<?php

use core\entities\Schedule\Service\Service;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user \core\entities\User\User */
/* @var $category \core\entities\Schedule\Service\Category */


$this->title =$category->name ;
$this->params['breadcrumbs'][] = ['label' => $category->parent->name ?: $category->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>
    <div class="service-index">

        <div class="invoice p-3 mb-3 mb-md-0">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title ">
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
                            'summary' => false,
                            'tableOptions' => [
                                'class' => 'table table-striped table-bordered',
                                'id' => 'service'
                            ],
                            'columns' => [
                                [
                                    'attribute' => 'parent category',
                                    'value' => fn (Service $model) => Html::a(
                                            Html::encode($model->category->parent->name),
                                            ['category', 'id' => $model->category->parent->id]
                                        ),
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'name',
                                    'value' => fn (Service $model) => Html::a(Html::encode($model->name), ['view', 'id' => $model->id]),
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'price_new',
                                    'value' => fn (Service $model)=> $model->price_new * $user->employee->rate->rate,
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

<?php
$js = <<< JS
 $(function () {
 
    $('#service').DataTable({
       "pageLength": -1, 
       "paging": true,
       "lengthChange": true,
       "lengthMenu": [[10, 25, 50, -1], [ 10, 25, 50,"All"]],
       "searching": true,
       "ordering": false,
       "info": true,
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