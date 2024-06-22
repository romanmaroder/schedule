<?php


/* @var $this \yii\web\View */

/** @var yii\data\ActiveDataProvider $dataProvider */


use core\entities\User\User;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Missed users';
$this->params['breadcrumbs'][] = $this->title;


PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>

<div class="card card-secondary">
    <div class="card-header">
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
                    'id' => 'missing'
                ],
                'columns' => [
                    //'id',
                    'username',
                    [
                        'attribute' => 'phone',
                        'value' => function (User $model) {
                            return Html::a(
                                Html::encode($model->phone),
                                'tel:' . $model->phone,
                                ['view', 'id' => $model->id]
                            );
                        },
                        'format' => 'raw',
                    ],
                ],
            ]
        );
        ?>
    </div>
</div>


<?php
$js = <<< JS
 $(function () {
 
    $('#missing').DataTable({
    
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
    }).buttons().container().appendTo('#missing_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>
