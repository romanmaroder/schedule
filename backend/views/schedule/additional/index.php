<?php

use backend\assets\DataTableAsset;
use core\entities\Schedule\Additional\Additional;
use core\helpers\StatusHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Schedule\AdditionalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('schedule/additional', 'Additional');
$this->params['breadcrumbs'][] = ['label' => Yii::t('schedule/additional', 'Additional'), 'url' => ['index']];
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
                        <h3 class="card-title ">
                            <?= Html::a(
                            Yii::t('app', 'Create'),
                            ['create'],
                            ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']
                        ) ?>
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
                                'id' => 'additional'
                            ],
                            'emptyText' => false,
                            'columns' => [
                                'id',
                                [
                                    'attribute' => 'name',
                                    'value' => fn (Additional $model) =>
                                         Html::a(Html::encode($model->name), ['view', 'id' => $model->id]),
                                    'format' => 'raw',
                                ],
                                [
                                'attribute' => 'category_id',
                                'filter' => $searchModel->categoriesList(),
                                'value' => 'category.name',
                            ],
                            [
                                'attribute' => 'status',
                                'filter' => $searchModel->statusList(),
                                'value' => fn (Additional $model) =>
                                     StatusHelper::statusLabel($model->status),
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
    </div>

<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#additional').DataTable({
       bStateSave: true,
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
    }).buttons().container().appendTo('#additional_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>