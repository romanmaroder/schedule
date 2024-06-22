<?php


/* @var $this \yii\web\View */

/* @var $dataProvider \yii\data\ActiveDataProvider */

use core\entities\Shop\Order\Order;
use core\helpers\OrderHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Orders';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet', 'url' => ['cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons','sweetalert2']
);
?>

            <?= GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'summary' => false,
                    'tableOptions' => [
                        'class' => 'table table-striped table-bordered',
                        'id' => 'order'
                    ],
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'value' => function (Order $model) {
                                return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
                            },
                            'format' => 'raw',
                        ],
                        'created_at:datetime',
                        [
                            'attribute' => 'status',
                            'value' => function (Order $model) {
                                return OrderHelper::statusLabel($model->current_status);
                            },
                            'format' => 'raw',
                        ],
                        ['class' => ActionColumn::class,
                            'template' => '{view}'],
                    ],
                ]
            ); ?>

<?php
$js = <<< JS
 $(function () {
 
    $('#order').DataTable({
    
       "paging": false,
       "lengthChange": false,
       "searching": true,
       "ordering": true,
       //"order": [[0, 'desc']],
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