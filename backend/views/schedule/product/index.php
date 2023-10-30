<?php

use hail812\adminlte3\assets\PluginAsset;
use schedule\entities\Schedule\Product\Product;
use schedule\helpers\PriceHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Schedule\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>

<div class="product-index">

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="invoice p-3 mb-3">
        <div class="card card-outline card-secondary">
            <div class='card-header'>
                <h3 class='card-title'>Common</h3>
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
                            'id' => 'product'
                        ],
                        'columns' => [
                            [
                                'value' => function (Product $model) {
                                    return $model->mainPhoto ? Html::img(
                                        $model->mainPhoto->getThumbFileUrl('file', 'admin')
                                    ) : null;
                                },
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width: 100px'],
                            ],
                            'id',
                            [
                                'attribute' => 'name',
                                'value' => function (Product $model) {
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
                                'value' => function (Product $model) {
                                    return PriceHelper::format($model->price_new);
                                },
                            ],
                            /*[
                                'attribute' => 'status',
                                'filter' => $searchModel->statusList(),
                                'value' => function (Product $model) {
                                    return ProductHelper::statusLabel($model->status);
                                },
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'text-align:center'],
                            ]*/
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
 
    $('#product').DataTable({
    
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
    }).buttons().container().appendTo('#product_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>