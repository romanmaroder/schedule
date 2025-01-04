<?php

use backend\assets\DataTableAsset;
use core\entities\CommonUses\Characteristic;
use core\helpers\CharacteristicHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\Shop\CharacteristicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop/characteristic','Characteristic');
$this->params['breadcrumbs'][] = $this->title;

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
                            <?= Html::a(Yii::t('app','Create'), ['create'], ['class' => 'btn btn-success btn-sm btn-shadow btn-gradient']) ?>
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
                            'value' => fn (Characteristic $model) =>
                                 Html::a(Html::encode($model->name), ['view', 'id' => $model->id]),
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'type',
                            'filter' => $searchModel->typesList(),
                            'value' => fn (Characteristic $model) =>
                                 CharacteristicHelper::typeName($model->type),
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
        </div>
    </div>
<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#characteristic').DataTable({
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
         },
    }).buttons().container().appendTo('#characteristic_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>