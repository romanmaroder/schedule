<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\EmployeeSearch */

/* @var $dataProvider \yii\data\ActiveDataProvider */


use backend\assets\DataTableAsset;
use backend\widgets\grid\RoleColumn;
use core\entities\User\Employee\Employee;
use core\helpers\EmployeeHelper;
use core\helpers\StatusHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('user/employee','Employees');
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
        <span class="card-title mb-2 mr-2 mb-md-0 ">
                <span class=""><?= Html::a(Yii::t('user/employee','Create Employee'), ['create'], ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?></span>
        </span>
        <span class="card-title ">
                <span class=""> <?= Html::a(Yii::t('user/employee','Create Existing Employee'), ['existing-user'], ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?></span>
        </span>

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
                    'id' => 'employee'
                ],
                'emptyText' => false,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    //'user_id',
                    [
                        'attribute' => 'first_name',
                        'value' => fn (Employee $model) =>
                             Html::a(Html::encode($model->getFullName()), ['/employee/view', 'id' => $model->id]),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'role',
                        'class' => RoleColumn::class,
                        //'filter' => $searchModel->rolesList(),
                        'contentOptions' => [
                            'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw',
                    ],
                    /*[
                        'attribute' => 'first_name',
                        'value' => function (Employee $model) {
                            return Html::a(Html::encode($model->first_name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'last_name',
                        'value' => function (Employee $model) {
                            return Html::a(Html::encode($model->last_name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],*/
                    [
                        'attribute' => 'phone',
                        'value' => fn (Employee $model) =>
                             Html::a(Html::encode($model->phone), 'tel:' . $model->phone, ['view', 'id' => $model->id]),
                        'contentOptions' => [
                            'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'color',
                        'value' => fn (Employee $model) =>
                             Html::tag(
                                'div',
                                '',
                                ['style' => 'width:20px;height:20px;margin:0 auto;background-color:' . $model->color]
                            ),
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'value' => fn ($model) =>
                             StatusHelper::statusLabel($model->status),
                        'contentOptions' => [
                                'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw'
                    ],
                    [
                        'class' => ActionColumn::class,
                        'urlCreator' => fn ($action, Employee $model, $key, $index, $column) =>
                             Url::toRoute([$action, 'id' => $model->id]),
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
    </div>
<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#employee').DataTable({
        bStateSave:true,
        pageLength: -1, 
        paging: true,
        lengthChange: true,
        lengthMenu: [[10, 25, 50, -1], [ 10, 25, 50,"All"]],
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
         }
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>