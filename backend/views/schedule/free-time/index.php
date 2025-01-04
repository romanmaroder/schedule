<?php



/* @var $this \yii\web\View */
/* @var $searchModel \backend\forms\Schedule\FreeTimeSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */


use backend\assets\DataTableAsset;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
DataTableAsset::register($this);
$this->title = Yii::t('schedule/free','Free time');
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
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
                            'summary' => false,
                            'tableOptions' => [
                                'class' => 'table table-striped table-bordered',
                                'id' => 'free'
                            ],
                            'emptyText' => false,
                            'columns' => [

                                //'id',
                                [
                                    'attribute' => 'start',
                                    'format' => ['date', 'php:d-m-Y'],
                                ],
                                [
                                    'attribute' => 'master_id',
                                    'value' => fn ($model) =>
                                         Html::a(
                                            Html::encode($model->master->username),
                                            ['view', 'id' => $model->id]
                                        ),
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'additional_id',
                                    'value' => fn ($model) =>
                                         Html::a(
                                            Html::encode($model->additional->name),
                                            ['/schedule/additional-category/view', 'id' => $model->additional->category_id]
                                        ),
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'notice',
                                    'value' => fn ($model) =>  $model->notice,
                                    'headerOptions' => ['class' => 'text-left'],
                                    'contentOptions' => [
                                        'class' => ['text-left align-middle']
                                    ],
                                    'format' => 'raw',

                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{copy}',
                                    'header' => '<i class="far fa-copy"></i>',
                                    //'header' => 'Copy',
                                    'headerOptions' => [
                                        'class'=>'text-center'
                                    ],
                                    'contentOptions' => [
                                        'class' => ['text-center align-middle']
                                    ],
                                    'buttonOptions' => [
                                        'class'=>'text-center'
                                    ],
                                    'buttons' => [
                                        'copy' => fn ($url, $model, $key) =>
                                              Html::a(
                                                Yii::t('app','Copy'),
                                                Url::to(['schedule/free-time/copy', 'id' => $model->id]),
                                                ['class' => 'btn bg-info bg-gradient text-shadow box-shadow btn-xs']
                                            ),
                                    ],
                                ],
                            ],
                        ]
                    ); ?>
                </div>
                </div>
            </div>
        </div>
    </div>

<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#free').DataTable({
        bStateSave:true,
       paging: true,
       lengthChange: false,
       searching: true,
       ordering: false,
       info: true,
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
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>