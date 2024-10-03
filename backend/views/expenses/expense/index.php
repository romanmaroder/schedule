<?php



/* @var $this \yii\web\View */
/* @var $searchModel \backend\forms\Expenses\ExpenseSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use core\entities\Expenses\Expenses\Expenses;
use core\helpers\PriceHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('expenses/expenses', 'Expenses');
$this->params['breadcrumbs'][] = ['label' => Yii::t('expenses/expenses', 'Expenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>

 <div class="expense-index">
        <div class="invoice p-3 mb-3">
            <div class="card card-secondary">
                <div class="card-header">
                <h3 class="card-title ">
                    <?= Html::a(Yii::t('app','Create'), ['create'], ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
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
                            'id' => 'expense'
                        ],
                        'columns' => [
                            //'id',
                            [
                                'attribute' => 'category_id',
                                'filter' => $searchModel->categoriesList(),
                                'value' => 'category.name',
                            ],
                            [
                                'attribute' => 'name',
                                'value' => function (Expenses $model) {
                                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'value',
                                'value' => function (Expenses $model) {
                                    return PriceHelper::format($model->value);
                                },
                            ],
                            'created_at:date'
                            /*[
                                'attribute' => 'status',
                                'filter' => $searchModel->statusList(),
                                'value' => function (Expenses $model) {
                                    return ExpenseHelper::statusLabel($model->status);
                                },
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'text-align:center'],
                            ],*/
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
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#expense').DataTable({
    
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
        language:{url:"$ru"}
    }).buttons().container().appendTo('#service_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>