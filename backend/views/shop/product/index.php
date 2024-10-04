<?php

use core\entities\Shop\Product\Product;
use core\helpers\PriceHelper;
use core\helpers\ProductHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\Shop\ProductSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop/product','Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/product','Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>

    <div class="product-index">

        <div class="invoice p-3 mb-3">
            <div class="card card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'>
                    <?= Html::a(Yii::t('app','Create'), ['create'], ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
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
                            'id' => 'product'
                        ],
                            'rowOptions' => function (Product $model) {
                                return $model->quantity <= 0 ? ['style' => 'background: #fdc'] : [];
                            },
                        'columns' => [
                            /*[
                                'value' => function (Product $model) {
                                    return $model->mainPhoto ? Html::img(
                                        $model->mainPhoto->getThumbFileUrl('file', 'admin')
                                    ) : null;
                                },
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width: 100px'],
                            ],*/
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
                            'quantity',
                            [
                                'attribute' => 'status',
                                'filter' => $searchModel->statusList(),
                                'value' => function (Product $model) {
                                    return ProductHelper::statusLabel($model->status);
                                },
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'text-align:center'],
                            ]
                        ],
                    ]
                ); ?>
            </div>
        </div>

    </div>
</div>

<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#product').DataTable({
    
       paging: false,
       lengthChange: false,
       searching: true,
       ordering: true,
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
         },
    }).buttons().container().appendTo('#product_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>