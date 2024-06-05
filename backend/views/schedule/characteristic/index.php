<?php

use hail812\adminlte3\assets\PluginAsset;
use core\entities\Schedule\Characteristic;
use core\helpers\CharacteristicHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Schedule\CharacteristicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Characteristic';
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>
<div class="characteristic-index">
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">
                <?= Html::a('Create characteristic', ['create'], ['class' => 'btn btn-success btn-sm btn-shadow btn-gradient']) ?>
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
                        'id' => 'characteristic'
                    ],
                    'columns' => [
                        [
                            'attribute' => 'name',
                            'value' => function (Characteristic $model) {
                                return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'type',
                            'filter' => $searchModel->typesList(),
                            'value' => function (Characteristic $model) {
                                return CharacteristicHelper::typeName($model->type);
                            },
                        ],
                        [
                            'attribute' => 'required',
                            'filter' => $searchModel->requiredList(),
                            'format' => 'boolean',
                        ],
                        //['class' => ActionColumn::class],
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
<?php
$js = <<< JS
 $(function () {
 
    $('#characteristic').DataTable({
    
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
    }).buttons().container().appendTo('#characteristic_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>